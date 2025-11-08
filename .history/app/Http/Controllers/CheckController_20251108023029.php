<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class CheckController extends Controller
{
    public function index(Request $request)
    {
        // Set language dari session
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        
        return view('welcome');
    }

    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'id'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        
        return redirect()->back();
    }

    public function process(Request $request)
    {
        // Set language dari session
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

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

        $locale = Session::get('locale', 'en');
        App::setLocale($locale);

        $pdf = Pdf::loadView('check_pdf', [
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'notFollowBack' => $users,
            'locale' => $locale
        ])->setPaper('a4', 'portrait');

        $filename = $locale === 'id' ? 'laporan_instagram_unfollowers.pdf' : 'instagram_unfollowers_report.pdf';
        
        return $pdf->download($filename);
    }
}