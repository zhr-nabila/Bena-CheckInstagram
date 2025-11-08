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

        try {
            $request->validate([
                'followers' => 'required|file|mimetypes:application/json,text/plain',
                'following' => 'required|file|mimetypes:application/json,text/plain',
            ]);

            $followersContent = file_get_contents($request->file('followers'));
            $followingContent = file_get_contents($request->file('following'));

            $followersData = json_decode($followersContent, true);
            $followingData = json_decode($followingContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['file' => 'Invalid JSON file format']);
            }

            // Process followers data
            $followers = $this->extractFollowers($followersData);
            
            // Process following data
            $following = $this->extractFollowing($followingData);

            $notFollowBack = array_diff($following, $followers);

            return view('welcome', [
                'followersCount' => count($followers),
                'followingCount' => count($following),
                'notFollowBack' => array_values($notFollowBack),
            ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Processing failed: ' . $e->getMessage()]);
        }
    }

    private function extractFollowers($data)
    {
        $usernames = [];
        
        if (!is_array($data)) {
            return $usernames;
        }

        // Check if it's the main followers array structure
        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $item) {
                if (isset($item['string_list_data'][0]['value'])) {
                    $usernames[] = $item['string_list_data'][0]['value'];
                } elseif (isset($item['title'])) {
                    $usernames[] = $item['title'];
                } elseif (isset($item['string_list_data'][0]['href'])) {
                    $username = basename(parse_url($item['string_list_data'][0]['href'], PHP_URL_PATH));
                    if (!empty($username)) {
                        $usernames[] = $username;
                    }
                }
            }
        } else {
            // Alternative structure
            $usernames = $this->extractUsernamesRecursive($data);
        }

        return array_unique(array_filter($usernames));
    }

    private function extractFollowing($data)
    {
        $usernames = [];
        
        if (!is_array($data)) {
            return $usernames;
        }

        // Check for relationships_following structure
        if (isset($data['relationships_following'])) {
            foreach ($data['relationships_following'] as $item) {
                if (isset($item['string_list_data'][0]['value'])) {
                    $usernames[] = $item['string_list_data'][0]['value'];
                } elseif (isset($item['title'])) {
                    $usernames[] = $item['title'];
                } elseif (isset($item['string_list_data'][0]['href'])) {
                    $username = basename(parse_url($item['string_list_data'][0]['href'], PHP_URL_PATH));
                    if (!empty($username)) {
                        $usernames[] = $username;
                    }
                }
            }
        } elseif (isset($data[0]) && is_array($data[0])) {
            // Direct array structure
            foreach ($data as $item) {
                if (isset($item['string_list_data'][0]['value'])) {
                    $usernames[] = $item['string_list_data'][0]['value'];
                } elseif (isset($item['title'])) {
                    $usernames[] = $item['title'];
                } elseif (isset($item['string_list_data'][0]['href'])) {
                    $username = basename(parse_url($item['string_list_data'][0]['href'], PHP_URL_PATH));
                    if (!empty($username)) {
                        $usernames[] = $username;
                    }
                }
            }
        } else {
            // Alternative structure
            $usernames = $this->extractUsernamesRecursive($data);
        }

        return array_unique(array_filter($usernames));
    }

    private function extractUsernamesRecursive($data)
    {
        $usernames = [];
        
        if (!is_array($data)) {
            return $usernames;
        }
        
        array_walk_recursive($data, function ($value, $key) use (&$usernames) {
            if (($key === 'value' || $key === 'title') && is_string($value) && !empty($value)) {
                // Skip URLs, extract only usernames
                if (!filter_var($value, FILTER_VALIDATE_URL) && !str_contains($value, '/')) {
                    $usernames[] = $value;
                }
            }
        });
        
        return $usernames;
    }

    public function downloadPdf(Request $request)
    {
        try {
            $request->validate([
                'users' => 'required|string',
                'followersCount' => 'required|integer',
                'followingCount' => 'required|integer',
            ]);

            $users = json_decode($request->input('users'), true);
            $followersCount = (int)$request->input('followersCount');
            $followingCount = (int)$request->input('followingCount');

            if (!is_array($users)) {
                $users = [];
            }

            $locale = Session::get('locale', 'en');
            App::setLocale($locale);

            $pdf = Pdf::loadView('check_pdf', [
                'followersCount' => $followersCount,
                'followingCount' => $followingCount,
                'notFollowBack' => array_values($users),
                'locale' => $locale
            ])->setPaper('a4', 'portrait');

            $filename = $locale === 'id' ? 'laporan_instagram_unfollowers.pdf' : 'instagram_unfollowers_report.pdf';
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'PDF download failed: ' . $e->getMessage()]);
        }
    }
}