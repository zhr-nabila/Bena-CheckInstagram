<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function checkUnfollow(Request $request)
    {
        $request->validate([
            'followers' => 'required|file|mimes:json',
            'following' => 'required|file|mimes:json',
        ]);

        $followersData = json_decode(file_get_contents($request->file('followers')->getRealPath()), true);
        $followingData = json_decode(file_get_contents($request->file('following')->getRealPath()), true);

        $followers = collect($followersData)
            ->pluck('string_list_data')
            ->map(fn($list) => $list[0]['value'] ?? null)
            ->filter()
            ->values()
            ->toArray();

        $following = collect($followingData)
            ->pluck('string_list_data')
            ->map(fn($list) => $list[0]['value'] ?? null)
            ->filter()
            ->values()
            ->toArray();

        $notFollowingBack = array_values(array_diff($following, $followers));

        return response()->json([
            'total_unfollowers' => count($notFollowingBack),
            'unfollowers' => $notFollowingBack,
        ]);
    }
}
