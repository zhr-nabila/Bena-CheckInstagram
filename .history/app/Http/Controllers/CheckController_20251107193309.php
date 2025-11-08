<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CheckController extends Controller
{
    public function index()
    {
        return view('check');
    }

    public function process(Request $request)
    {
        // Validasi file tapi pakai mimetypes lebih toleran
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
            // Kadang username ada di title, kadang di string_list_data
            return $item['title'] ?? ($item['string_list_data'][0]['href'] ?? null);
        })->filter()->map(function($href){
            // ambil username dari link
            return basename(parse_url($href, PHP_URL_PATH));
        })->values()->toArray();

        // Cari siapa yang tidak follow balik
        $notFollowBack = array_diff($following, $followers);

        return view('check', [
            'followersCount' => count($followers),
            'followingCount' => count($following),
            'notFollowBack' => $notFollowBack,
        ]);
    }
    public function downloadCsv(Request $request)
{
    $users = $request->input('users', []);
    $filename = 'unfollowers.csv';

    $handle = fopen('php://memory', 'w');
    fputcsv($handle, ['Username']); // header
    foreach ($users as $user) {
        fputcsv($handle, [$user]);
    }
    rewind($handle);

    return response()->streamDownload(function() use ($handle) {
        fpassthru($handle);
    }, $filename, ['Content-Type' => 'text/csv']);
}
}
