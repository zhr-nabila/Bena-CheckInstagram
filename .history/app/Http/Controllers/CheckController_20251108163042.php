<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckController extends Controller
{
    public function index(Request $request)
    {
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

            // Process data
            $followers = $this->extractFollowersData($followersData);
            $following = $this->extractFollowingData($followingData);

            Log::info('Processing results:', [
                'followers_count' => count($followers),
                'following_count' => count($following)
            ]);

            $notFollowBack = array_diff($following, $followers);

            return view('welcome', [
                'followersCount' => count($followers),
                'followingCount' => count($following),
                'notFollowBack' => array_values($notFollowBack),
            ]);

        } catch (\Exception $e) {
            Log::error('Process error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Processing failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Extract followers data dari berbagai format
     */
    private function extractFollowersData($data)
    {
        $usernames = [];

        // Format 1: File followers_1.json (single user)
        if (isset($data['string_list_data']) && is_array($data['string_list_data'])) {
            foreach ($data['string_list_data'] as $item) {
                if (isset($item['value']) && $this->isValidUsername($item['value'])) {
                    $usernames[] = $item['value'];
                }
            }
        }

        // Format 2: File followers.json (multiple users - array of objects)
        if (is_array($data) && isset($data[0]) && is_array($data[0])) {
            foreach ($data as $item) {
                // Format: [{"string_list_data": [{"value": "username"}]}]
                if (isset($item['string_list_data']) && is_array($item['string_list_data'])) {
                    foreach ($item['string_list_data'] as $stringData) {
                        if (isset($stringData['value']) && $this->isValidUsername($stringData['value'])) {
                            $usernames[] = $stringData['value'];
                        }
                    }
                }
                // Alternative format
                elseif (isset($item['value']) && $this->isValidUsername($item['value'])) {
                    $usernames[] = $item['value'];
                }
            }
        }

        // Format 3: Nested structure
        if (isset($data['relationships_followers']) && is_array($data['relationships_followers'])) {
            return $this->extractFollowersData($data['relationships_followers']);
        }

        return array_unique(array_filter($usernames));
    }

    /**
     * Extract following data dari berbagai format
     */
    private function extractFollowingData($data)
    {
        $usernames = [];

        // Format: relationships_following (seperti file yang kamu kirim)
        if (isset($data['relationships_following']) && is_array($data['relationships_following'])) {
            foreach ($data['relationships_following'] as $item) {
                // Gunakan title sebagai username (sesuai file kamu)
                if (isset($item['title']) && $this->isValidUsername($item['title'])) {
                    $usernames[] = $item['title'];
                }
                // Fallback: extract dari href
                elseif (isset($item['string_list_data'][0]['href'])) {
                    $username = $this->extractUsernameFromUrl($item['string_list_data'][0]['href']);
                    if ($username) {
                        $usernames[] = $username;
                    }
                }
            }
        }

        // Format alternatif: direct array
        if (is_array($data) && isset($data[0]) && is_array($data[0])) {
            foreach ($data as $item) {
                if (isset($item['title']) && $this->isValidUsername($item['title'])) {
                    $usernames[] = $item['title'];
                }
                elseif (isset($item['value']) && $this->isValidUsername($item['value'])) {
                    $usernames[] = $item['value'];
                }
            }
        }

        return array_unique(array_filter($usernames));
    }

    /**
     * Validasi username
     */
    private function isValidUsername($username)
    {
        if (empty($username) || strlen($username) > 30) {
            return false;
        }

        // Skip URLs
        if (filter_var($username, FILTER_VALIDATE_URL)) {
            return false;
        }

        // Skip jika mengandung path separator
        if (strpos($username, '/') !== false) {
            return false;
        }

        // Username biasanya hanya mengandung huruf, angka, underscore, titik
        return preg_match('/^[a-zA-Z0-9._]+$/', $username);
    }

    /**
     * Extract username dari URL Instagram
     */
    private function extractUsernameFromUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);
        if ($path) {
            // Remove /_u/ prefix jika ada
            $path = str_replace('/_u/', '/', $path);
            $username = basename($path);
            if ($this->isValidUsername($username)) {
                return $username;
            }
        }

        return null;
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
            Log::error('PDF Download error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'PDF download failed: ' . $e->getMessage()]);
        }
    }
}