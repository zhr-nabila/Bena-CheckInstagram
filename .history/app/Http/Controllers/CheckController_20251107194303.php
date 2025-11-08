<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function process(Request $request)
    {
        $request->validate([
            'followers' => 'required|file|mimetypes:application/json,text/plain',
            'following' => 'required|file|mimetypes:application/json,text/plain',
        ]);

        // Ambil isi file
        $followersData = json_decode(file_get_contents($request->file('followers')), true);
        $followingData = json_decode(file_get_contents($request->file('following')), true);

        // Ambil list username followers
        $followers = collect($followersData)->map(function ($item) {
            return $item['string_list_data'][0]['value'] ?? null;
        })->filter()->values()->toArray();

        // Ambil list username following
        $following = collect($followingData['relationships_following'])->map(function ($item) {
            return $item['title'] ?? ($item['string_list_data'][0]['href'] ?? null);
        })->filter()->map(function ($href) {
            return basename(parse_url($href, PHP_URL_PATH));
        })->values()->toArray();

        // Cari siapa yang tidak follow balik
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
        $filename = 'unfollowers.csv';

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Username']); // Header
        foreach ($users as $user) {
            fputcsv($handle, [$user]);
        }
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
