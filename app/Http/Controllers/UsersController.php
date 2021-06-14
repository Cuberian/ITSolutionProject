<?php

namespace App\Http\Controllers;

use App\Models\SavedRecord;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getSavedRecords()
    {
        $user = User::find(auth()->user()->id);
        $saved_records = SavedRecord::all()->where('user_id', $user->id)->toArray();
        return response()->json($saved_records);
    }

    public function addSavedRecord(Request $request) {
        $record = [
            'object_id' => $request['object_id'],
            'object_type' => $request['object_type'],
            'user_id' => auth()->user()->id
        ];

        SavedRecord::create($record);
        return response()->json(['message' => 'OK']);
    }

    public function deleteSavedRecord($record_type, $record_id) {
        $saved_record = SavedRecord::where(
            ['object_type' => $record_type, 'object_id' => $record_id, 'user_id'=>auth()->user()->id])->first();
        $saved_record->delete();
        return response()->json(['message' => 'OK']);
    }
}
