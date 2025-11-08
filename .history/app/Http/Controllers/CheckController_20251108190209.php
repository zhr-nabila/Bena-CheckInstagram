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

            // IMPROVED: Gunakan method yang lebih akurat
            $followers = $this->extractFollowersAccurate($followersData);
            $following = $this->extractFollowingAccurate($followingData);

            // IMPROVED: Filter false positives
            $notFollowBack = $this->getAccurateUnfollowers($followers, $following);

            Log::info('Accurate processing results:', [
                'followers_count' => count($followers),
                'following_count' => count($following),
                'unfollowers_count' => count($notFollowBack)
            ]);

            return view('welcome', [
                'followersCount' => count($followers),
                'followingCount' => count($following),
                'notFollowBack' => $notFollowBack,
            ]);

        } catch (\Exception $e) {
            Log::error('Process error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Processing failed: ' . $e->getMessage()]);
        }
    }

    /**
     * IMPROVED: Extract followers dengan multiple method untuk accuracy
     */
    private function extractFollowersAccurate($data)
    {
        $usernames = [];
        
        // Method 1: Standard array format
        if (is_array($data) && isset($data[0]) && is_array($data[0])) {
            foreach ($data as $item) {
                if (isset($item['string_list_data'][0]['value'])) {
                    $username = $item['string_list_data'][0]['value'];
                    if ($this->isValidUsername($username)) {
                        $usernames[] = $username;
                    }
                }
            }
        }
        
        // Method 2: Single object format (followers_1.json)
        elseif (isset($data['string_list_data']) && is_array($data['string_list_data'])) {
            foreach ($data['string_list_data'] as $item) {
                if (isset($item['value']) && $this->isValidUsername($item['value'])) {
                    $usernames[] = $item['value'];
                }
            }
        }
        
        // Method 3: Deep search untuk handle berbagai format
        else {
            $usernames = $this->deepSearchUsernames($data, 'followers');
        }

        return array_unique(array_filter($usernames));
    }

    /**
     * IMPROVED: Extract following dengan focus ke accuracy
     */
    private function extractFollowingAccurate($data)
    {
        $usernames = [];

        // Method 1: Standard following format
        if (isset($data['relationships_following']) && is_array($data['relationships_following'])) {
            foreach ($data['relationships_following'] as $item) {
                // Prioritize 'title' field (lebih reliable)
                if (isset($item['title']) && $this->isValidUsername($item['title'])) {
                    $usernames[] = $item['title'];
                }
                // Fallback ke value field
                elseif (isset($item['string_list_data'][0]['value'])) {
                    $username = $item['string_list_data'][0]['value'];
                    if ($this->isValidUsername($username)) {
                        $usernames[] = $username;
                    }
                }
            }
        }
        
        // Method 2: Alternative format
        elseif (is_array($data) && isset($data[0]) && is_array($data[0])) {
            foreach ($data as $item) {
                if (isset($item['title']) && $this->isValidUsername($item['title'])) {
                    $usernames[] = $item['title'];
                }
                elseif (isset($item['string_list_data'][0]['value'])) {
                    $username = $item['string_list_data'][0]['value'];
                    if ($this->isValidUsername($username)) {
                        $usernames[] = $username;
                    }
                }
            }
        }

        return array_unique(array_filter($usernames));
    }

    /**
     * IMPROVED: Algorithm untuk accurate unfollower detection
     */
    private function getAccurateUnfollowers($followers, $following)
    {
        $notFollowBack = array_diff($following, $followers);
        
        // Filter false positives
        $accurateUnfollowers = [];
        foreach ($notFollowBack as $username) {
            if ($this->isLikelyRealUnfollower($username, $followers)) {
                $accurateUnfollowers[] = $username;
            }
        }

        Log::info('Unfollower filtering:', [
            'raw_count' => count($notFollowBack),
            'filtered_count' => count($accurateUnfollowers),
            'filtered_out' => count($notFollowBack) - count($accurateUnfollowers)
        ]);

        return $accurateUnfollowers;
    }

    /**
     * IMPROVED: Filter untuk reduce false positives
     */
    private function isLikelyRealUnfollower($username, $followers)
    {
        // Skip jika username ada di followers (double check)
        if (in_array($username, $followers)) {
            return false;
        }

        // Skip usernames yang terlalu generic (mungkin error)
        if ($this->isGenericUsername($username)) {
            return false;
        }

        // Skip usernames dengan pattern suspicious
        if ($this->hasSuspiciousPattern($username)) {
            return false;
        }

        return true;
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
     * Deep search untuk handle berbagai format JSON
     */
    private function deepSearchUsernames($data, $type)
    {
        $usernames = [];
        
        if (!is_array($data)) {
            return $usernames;
        }
        
        array_walk_recursive($data, function ($value, $key) use (&$usernames, $type) {
            if (is_string($value) && $this->isValidUsername($value)) {
                // Additional filtering berdasarkan type
                if ($type === 'followers') {
                    if (!$this->isGenericUsername($value)) {
                        $usernames[] = $value;
                    }
                } else {
                    $usernames[] = $value;
                }
            }
        });
        
        return array_unique($usernames);
    }

    /**
     * Filter generic/usernames yang mungkin error
     */
    private function isGenericUsername($username)
    {
        $genericPatterns = [
            'instagram', 'facebook', 'meta', 'admin', 'user', 'test',
            'username', 'official', 'verified', 'account'
        ];
        
        $lowerUsername = strtolower($username);
        
        foreach ($genericPatterns as $pattern) {
            if (strpos($lowerUsername, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Deteksi suspicious patterns
     */
    private function hasSuspiciousPattern($username)
    {
        // Username dengan banyak angka berurutan
        if (preg_match('/\d{5,}/', $username)) {
            return true;
        }
        
        // Username terlalu pendek
        if (strlen($username) < 3) {
            return true;
        }
        
        return false;
    }

    public function downloadPDF(Request $request)
{
    try {
        $users = json_decode($request->input('users'), true) ?? [];
        $followersCount = $request->input('followersCount', 0);
        $followingCount = $request->input('followingCount', 0);
        
        $pdf = PDF::loadView('pdf.report', [
            'notFollowBack' => $users,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ]);
        
        // GUNAKAN STREAM() BUKAN DOWNLOAD() - buka di tab baru
        return $pdf->stream('instagram_unfollowers_report.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="instagram_unfollowers_report.pdf"'
        ]);
        
    } catch (\Exception $e) {
        // Fallback ke download biasa kalau stream gagal
        if (isset($pdf)) {
            return $pdf->download('instagram_unfollowers_report.pdf');
        }
        
        return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
    }
}
}