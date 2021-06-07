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
        $saved_records = $user->savedRecords;
        return response()->json($saved_records);
    }

    public function addSavedRecord(Request $request) {
        SavedRecord::create($request);
        return response()->json(['message' => 'OK']);
    }

    public function deleteSavedRecord($record_id) {
        $saved_record = SavedRecord::find($record_id);
        $saved_record->delete();
        return response()->json(['message' => 'OK']);
    }
}
