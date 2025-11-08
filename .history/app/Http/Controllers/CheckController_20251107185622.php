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
        $request->validate([
            'followers' => 'required|file|mimes:json',
            'following' => 'required|file|mimes:json',
        ]);

        // baca file followers
        $followersData = json_decode(file_get_contents($request->file('followers')->getPathname()), true);
        $followingData = json_decode(file_get_contents($request->file('following')->getPathname()), true);

        $followers = [];
        $following = [];

        // parsing followers (biasanya di string_list_data.value)
        foreach ($followersData as $f) {
            if (isset($f['string_list_data'][0]['value'])) {
                $followers[] = $f['string_list_data'][0]['value'];
            }
        }

        // parsing following (di title)
        if (isset($followingData['relationships_following'])) {
            foreach ($followingData['relationships_following'] as $f) {
                if (!empty($f['title'])) {
                    $following[] = $f['title'];
                }
            }
        }

        // cari yang gak follow balik
        $notFollowingBack = array_diff($following, $followers);

        return view('result', [
            'followers_count' => count($followers),
            'following_count' => count($following),
            'not_following_back' => $notFollowingBack,
        ]);
    }
}
