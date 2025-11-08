<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        return view('welcome'); // ganti check → welcome
    }

    public function process(Request $request)
    {
        $request->validate([
            'followers' => 'required|file|mimes:json',
            'following' => 'required|file|mimes:json',
        ]);

        $followersData = json_decode(file_get_contents($request->file('followers')), true);
        $followingData = json_decode(file_get_contents($request->file('following')), true);

        // Ambil username followers
        $followers = collect($followersData)->map(function ($item) {
            return $item['string_list_data'][0]['value'] ?? null;
        })->filter()->values()->toArray();

        // Ambil username following dari URL
        $following = collect($followingData['relationships_following'])->map(function ($item) {
            if(isset($item['string_list_data'][0]['href'])){
                $url = $item['string_list_data'][0]['href'];
                return basename(parse_url($url, PHP_URL_PATH));
            }
            return null;
        })->filter()->values()->toArray();

        $notFollowBack = array_diff($following, $followers);

        return view('welcome', [
            'followersCount' => count($followers),
            'followingCount' => count($following),
            'notFollowBack' => $notFollowBack,
        ]);
    }

    // Optional: download CSV
    public function downloadCsv(Request $request)
    {
        $data = $request->input('notFollowBack', []);
        $filename = "not_follow_back.csv";

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Username']);

        foreach($data as $user){
            fputcsv($handle, [$user]);
        }

        fclose($handle);

        return response()->download($filename);
    }
}
