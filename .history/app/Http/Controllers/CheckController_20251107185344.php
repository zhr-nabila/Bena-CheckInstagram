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
            'followers' => 'required|file|mimes:json,txt',
            'following' => 'required|file|mimes:json,txt',
        ]);

        // Simpan file sementara
        $followersPath = $request->file('followers')->getRealPath();
        $followingPath = $request->file('following')->getRealPath();

        // Decode JSON
        $followersData = json_decode(file_get_contents($followersPath), true);
        $followingData = json_decode(file_get_contents($followingPath), true);

        if (!$followersData || !$followingData) {
            return back()->with('error', 'Gagal membaca file JSON. Pastikan format sesuai.');
        }

        // Ambil username followers
        $followers = [];
        foreach ($followersData as $f) {
            if (isset($f['string_list_data'][0]['value'])) {
                $followers[] = strtolower($f['string_list_data'][0]['value']);
            }
        }

        // Ambil username following
        $following = [];
        foreach ($followingData as $f) {
            if (isset($f['string_list_data'][0]['value'])) {
                $following[] = strtolower($f['string_list_data'][0]['value']);
            }
        }

        // Cari unfollowers (yang kita follow tapi ga follow balik)
        $unfollowers = array_diff($following, $followers);

        return view('check', [
            'unfollowers' => $unfollowers,
            'followersCount' => count($followers),
            'followingCount' => count($following),
        ]);
    }
}
