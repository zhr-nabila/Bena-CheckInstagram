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
        // Validasi file
        $request->validate([
            'followers' => 'required|file|mimes:json',
            'following' => 'required|file|mimes:json',
        ]);

        // Ambil isi file JSON
        $followersData = json_decode(file_get_contents($request->file('followers')), true);
        $followingData = json_decode(file_get_contents($request->file('following')), true);

        // Ambil username dari followers (pakai value)
        $followers = collect($followersData)->map(function ($item) {
            return $item['string_list_data'][0]['value'] ?? null;
        })->filter()->values()->toArray();

        // Ambil username dari following (pakai title)
        $following = collect($followingData['relationships_following'])->map(function ($item) {
            return $item['title'] ?? null;
        })->filter()->values()->toArray();

        // Cari siapa yang tidak follow balik
        $notFollowBack = array_diff($following, $followers);

        // Kirim hasil ke view
        return view('check', [
            'followersCount' => count($followers),
            'followingCount' => count($following),
            'notFollowBack' => $notFollowBack,
        ]);
    }
}
