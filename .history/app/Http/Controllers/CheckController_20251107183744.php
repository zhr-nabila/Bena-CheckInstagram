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

        // Baca isi JSON
        $followersData = json_decode(file_get_contents($followersFile->getRealPath()), true);
        $followingData = json_decode(file_get_contents($followingFile->getRealPath()), true);

        // Ambil username followers
        $followers = [];
        if (isset($followersData['relationships_followers'])) {
            foreach ($followersData['relationships_followers'] as $f) {
                foreach ($f['string_list_data'] as $d) {
                    $followers[] = $d['value'];
                }
            }
        }

        // Ambil username following
        $following = [];
        if (isset($followingData['relationships_following'])) {
            foreach ($followingData['relationships_following'] as $f) {
                foreach ($f['string_list_data'] as $d) {
                    $following[] = $d['value'];
                }
            }
        }

        // Bandingkan — cari siapa yg kamu follow tapi dia ga follow balik
        $unfollowers = array_diff($following, $followers);

        // Kirim hasil ke view
        return view('result', ['unfollowers' => $unfollowers]);
    }
}
