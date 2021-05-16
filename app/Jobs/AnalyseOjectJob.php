<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\Post;
use App\Models\PostPicture;
use App\Models\User;
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

class AnalyseOjectJob implements ShouldQueue
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

    public function  setPosts($author_type, $author_id, $posts) {
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
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws RequestException
     */
    public function handle()
    {
        $res = Http::get(Config::get('app.python_host') . '/api/'.$this->type.'/'.$this->obj_id)
            ->throw()
            ->json();

        switch ($this->type) {
            case 'user':
                print_r($res['user']);
                $userData = [
                    'fullname' => "{$res['user']['last_name']} {$res['user']['first_name']}",
                    'avatar' => $res['user']['photo_200'],
                    'is_closed' => !!$res['user']['is_closed'],
                    'toxicity' => (float) $res['user']['toxicity']
                ];
                print_r($userData);
                $user = UserVK::updateOrCreate(['wall_id' => $res['user']['id']], $userData);
                if($res['posts'] != null && count($res['posts']) > 0)
                    $this->setPosts('App\Models\UserVK', $user->id, $res['posts']);
                break;
            case 'group':
                $groupData = [
                    'wall_id' => $res['group']['id'],
                    'name' => $res['group']['name'],
                    'screen_name' => $res['group']['screen_name'],
                    'info' => $res['group']['description'],
                    'avatar' => $res['group']['photo_200'],
                    'is_closed' => $res['group']['is_closed'],
                    'toxicity' => $res['group']['toxicity']
                ];

                $group = Group::updateOrCreate($groupData);
                $this->setPosts('App\Models\Group', $group->id, $res['posts']);
                break;

            case 'post':
                $ownerData = [
                    'wall_id' => $res['owner']['id'],
                    'fullname' => "{$res['owner']['last_name']} {$res['user']['first_name']}",
                    'avatar' => $res['owner']['photo_200'],
                    'is_closed' => $res['owner']['is_closed'],
                    'toxicity' => $res['owner']['toxicity']
                ];
                $group= Group::updateOrCreate($ownerData);

                $this->setPosts('App\Models\Group', $group->id, [$res['post']]);
                break;
        }
    }
}
