<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $followersData = json_decode(file_get_contents($request->file('followers')), true);
        $followingData = json_decode(file_get_contents($request->file('following')), true);

        $followers = collect($followersData)
            ->map(fn($item) => $item['string_list_data'][0]['value'] ?? null)
            ->filter()
            ->values()
            ->toArray();

        $following = collect($followingData['relationships_following'])
            ->map(fn($item) => $item['title'] ?? ($item['string_list_data'][0]['href'] ?? null))
            ->filter()
            ->map(fn($href) => basename(parse_url($href, PHP_URL_PATH)))
            ->values()
            ->toArray();

        $notFollowBack = array_diff($following, $followers);

        return view('welcome', [
            'followersCount' => count($followers),
            'followingCount' => count($following),
            'notFollowBack' => $notFollowBack,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $users = $request->input('users', []);
        $followersCount = $request->input('followersCount', 0);
        $followingCount = $request->input('followingCount', 0);

        $pdf = Pdf::loadView('check_pdf', [
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'notFollowBack' => $users,
        ])->setPaper('a4', 'portrait'); // pastikan portrait

        return $pdf->download('instagram_unfollowers.pdf');
    }
}
