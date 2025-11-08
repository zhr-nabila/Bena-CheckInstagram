<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        return view('check');
    }

    public function process(Request $request)
    {
        try {
            $request->validate([
                'followers' => 'required|file|mimes:json',
                'following' => 'required|file|mimes:json',
            ]);

            $followersJson = file_get_contents($request->file('followers'));
            $followingJson = file_get_contents($request->file('following'));

            if (!$followersJson || !$followingJson) {
                throw new \Exception("File JSON gagal dibaca");
            }

            $followersData = json_decode($followersJson, true);
            $followingData = json_decode($followingJson, true);

            if (!$followersData || !$followingData) {
                throw new \Exception("File JSON tidak valid");
            }

            // followers ambil value
            $followers = collect($followersData)->map(function ($item) {
                return $item['string_list_data'][0]['value'] ?? null;
            })->filter()->values()->toArray();

            // following ambil title
            $following = collect($followingData['relationships_following'])->map(function ($item) {
                return $item['title'] ?? null;
            })->filter()->values()->toArray();

            $notFollowBack = array_diff($following, $followers);

            return view('check', [
                'followersCount' => count($followers),
                'followingCount' => count($following),
                'notFollowBack' => $notFollowBack,
            ]);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
