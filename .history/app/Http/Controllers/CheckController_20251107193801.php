<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CheckController extends Controller
{
    public function welcome()
    {
        return view('welcome'); // pake welcome.blade.php
    }

    public function process(Request $request)
    {
        $request->validate([
            'followers' => 'required|file|mimes:json',
            'following' => 'required|file|mimes:json',
        ]);

        $followersData = json_decode(file_get_contents($request->file('followers')), true);
        $followingData = json_decode(file_get_contents($request->file('following')), true);

        $followers = collect($followersData)->map(function ($item) {
            return $item['string_list_data'][0]['value'] ?? null;
        })->filter()->values()->toArray();

        $following = collect($followingData['relationships_following'])->map(function ($item) {
            return $item['title'] ?? null;
        })->filter()->values()->toArray();

        $notFollowBack = array_diff($following, $followers);

        return view('welcome', [
            'followersCount' => count($followers),
            'followingCount' => count($following),
            'notFollowBack' => $notFollowBack,
        ]);
    }

    public function downloadCsv(Request $request)
    {
        $users = $request->input('users', []);
        $filename = "unfollowers.csv";

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Username']);
        foreach($users as $user) {
            fputcsv($handle, [$user]);
        }
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
