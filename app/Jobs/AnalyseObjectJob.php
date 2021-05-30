<?php

namespace App\Jobs;

use App\Models\AnalysisRequestObject;
use App\Models\Group;
use App\Models\Post;
use App\Models\PostPicture;
use App\Models\UserVK;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Http\Client\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use function GuzzleHttp\Psr7\str;

class AnalyseObjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $type;
    private string $obj_id;
    private int $req_id;

    /**
     * Create a new job instance.
     *
     * @param $request_id
     * @param $type
     * @param $id
     */
    public function __construct($request_id, $type, $id)
    {
        $this->type = $type;
        $this->obj_id = $id;
        $this->req_id = $request_id;
    }

    /**
     * Записать результаты анализа пользователя в БД
     * @param $user - пользователь, прошедший анализ
     * @param $posts - посты пользователя, прошедшие анализ
     * @param $description
     */
    public function setUser ($user, $posts, $description) {
        print_r($user);
        if($user) {
            $userData = [
                'fullname' => "{$user['last_name']} {$user['first_name']}",
                'avatar' => $user['photo_200'],
                'is_closed' => !!$user['is_closed'],
                'toxicity' => (float)$user['toxicity']
            ];
            print_r($userData);
            $userVK = UserVK::updateOrCreate(['wall_id' => $user['id']], $userData);
            if ($posts != null && count($posts) > 0)
                $this->setPosts('App\Models\UserVK', $userVK->id, $posts);

            AnalysisRequestObject::create([
                'request_id' => $this->req_id,
                'type' => 'user',
                'object_id' => $userVK->id,
                'analysis_type' => $userData['is_closed'] ? 'error' : 'success',
                'requested_id' => $this->obj_id,
                'result_description' => $description
            ]);
        }
        else {
            AnalysisRequestObject::create([
                'request_id' => $this->req_id,
                'type' => 'user',
                'object_id' => null,
                'analysis_type' => 'error',
                'requested_id' => $this->obj_id,
                'result_description' => $description
            ]);
        }
    }

    /**
     * Записать результаты анализа группы в БД
     * @param $group - группа, прошедшая анализ
     * @param $posts - посты группы, прошедшие анализ
     * @param $description
     */
    public function setGroup ($group, $posts, $description) {
        if($group) {
            $groupData = [
                'name' => $group['name'],
                'screen_name' => $group['screen_name'],
                'info' => $group['description'],
                'avatar' => $group['photo_200'],
                'is_closed' => $group['is_closed'],
                'toxicity' => $group['toxicity']
            ];

            $groupVK = Group::updateOrCreate(['wall_id' => $group['id']], $groupData);
            if ($posts != null && count($posts) > 0)
                $this->setPosts('App\Models\Group', $groupVK->id, $posts);

            AnalysisRequestObject::create([
                'request_id' => $this->req_id,
                'type' => 'group',
                'object_id' => $groupVK->id,
                'analysis_type' => $groupData['is_closed'] ? 'error' : 'success',
                'requested_id' => $this->obj_id,
                'result_description' => $description
            ]);
        }
        else {
            AnalysisRequestObject::create([
                'request_id' => $this->req_id,
                'type' => 'group',
                'object_id' => null,
                'analysis_type' => 'error',
                'requested_id' => $this->obj_id,
                'result_description' => $description
            ]);
        }
    }

    /**
     * Записать результаты анализа поста в БД
     * @param $owner - владелец поста, прошедшего анализ
     * @param $post - пост, прошедший анализ
     */
    public function setPost($owner, $post) {
        $ownerData = [
            'wall_id' => $owner['id'],
            'fullname' => "{$owner['last_name']} {$owner['first_name']}",
            'avatar' => $owner['photo_200'],
            'is_closed' => $owner['is_closed'],
            'toxicity' => $owner['toxicity']
        ];
        $group= Group::updateOrCreate($ownerData);

        $postVK = $this->setPosts('App\Models\Group', $group->id, [$post])[0];

        AnalysisRequestObject::create([
            'request_id' => $this->req_id,
            'type' => 'post',
            'object_id' => $postVK->id
        ]);
    }

    public function setPosts($author_type, $author_id, $posts) {
        $createdPosts = [];
        foreach ($posts as $post)
        {
            $postData = [
                'author_type' => $author_type,
                'author_id' => $author_id,
                'text' => $post['text'],
                'toxicity' => $post['toxicity_mark']
            ];

            $post = Post::updateOrCreate($postData);
            if($post['attachments'] != null) {
                foreach ($post['attachments'] as $image) {
                    if ($image['type'] == 'photo') {
                        $imageData = [
                            'post_id' => $post->id,
                            'picture' => $image['sizes'][count($image['sizes']) - 3],
                        ];
                        PostPicture::create($imageData);
                    }
                }
            }
            $createdPosts[] = $post;
        }

        return $createdPosts;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws RequestException
     */
    public function handle()
    {
        try {
            $res = Http::get(Config::get('app.python_host') . '/api/' . $this->type . '/' . $this->obj_id)
                ->throw()
                ->json();

            switch ($this->type) {
                case 'user':
                    $this->setUser($res['user'], $res['posts'], $res['description']);
                    break;
                case 'group':
                    $this->setGroup($res['group'], $res['posts'], $res['description']);
                    break;
                case 'post':
                    $this->setPost($res['owner'], $res['post']);
                    break;

            }
        }
        catch (\Exception $e) {
            print_r(['message' => 'I`m here']);
        }
    }
}
