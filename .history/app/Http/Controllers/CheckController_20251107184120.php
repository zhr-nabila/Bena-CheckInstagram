<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function process(Request $request)
{
    // Validasi file
    $request->validate([
        'followers' => 'required|file|mimes:json',
        'following' => 'required|file|mimes:json',
    ]);

    // Ambil file
    $followersFile = $request->file('followers');
    $followingFile = $request->file('following');

    // Decode JSON ke array PHP
    $followersData = json_decode(file_get_contents($followersFile->getRealPath()), true);
    $followingData = json_decode(file_get_contents($followingFile->getRealPath()), true);

    // Pastikan datanya array
    if (!is_array($followersData) || !is_array($followingData)) {
        return back()->with('error', 'Format file tidak sesuai.');
    }

    // Ambil username followers
    $followers = [];
    foreach ($followersData as $item) {
        if (isset($item['string_list_data'][0]['value'])) {
            $followers[] = $item['string_list_data'][0]['value'];
        }
    }

    // Ambil username following
    $following = [];
    foreach ($followingData as $item) {
        if (isset($item['string_list_data'][0]['value'])) {
            $following[] = $item['string_list_data'][0]['value'];
        }
    }

    // Bandingkan: siapa yang kamu follow tapi dia nggak follow balik
    $unfollowers = array_diff($following, $followers);

    // Kirim hasil ke view
    return view('result', ['unfollowers' => $unfollowers]);
}

}
