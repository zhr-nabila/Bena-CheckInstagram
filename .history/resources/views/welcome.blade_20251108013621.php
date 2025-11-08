<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bena • Instagram Analytics</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Controls -->
    <div class="controls">
        <button class="control-btn language-toggle">EN</button>
        <button class="control-btn theme-toggle">Theme</button>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="logo">bena</div>
            <h1>Discover Your True Instagram Circle</h1>
            <p>Find out who doesn't follow you back with our premium analytics tool</p>
            
            <div class="features">
                <div class="feature">
                    <h3>Accurate Analysis</h3>
                    <p>Precise detection of non-reciprocal followers</p>
                </div>
                <div class="feature">
                    <h3>Premium Reports</h3>
                    <p>Beautiful PDF reports with insights</p>
                </div>
                <div class="feature">
                    <h3>Secure & Private</h3>
                    <p>Your data never leaves your browser</p>
                </div>
            </div>

            <a href="#upload" class="scroll-btn">Start Analysis</a>
        </div>
    </section>

    <!-- Upload Section -->
    <section id="upload" class="upload-section">
        <div class="container">
            <div class="upload-card">
                <div class="upload-area">
                    <div class="upload-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                    </div>
                    <div class="upload-text">
                        <h3>Upload Your Instagram Data</h3>
                        <p>Select followers.json and following.json files</p>
                    </div>
                    <button class="upload-btn">Choose Files</button>
                    <p class="upload-hint">Drag & drop files or click to browse</p>
                </div>

                <div class="file-list"></div>

                <form id="checkForm" action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                    @csrf
                    <button type="submit" class="submit-btn" disabled>Upload Both Files to Continue</button>
                </form>

                <div class="loading">
                    <div class="spinner"></div>
                    <p>Analyzing your Instagram data...</p>
                </div>
            </div>

            @if (isset($followersCount))
            <!-- Results Section -->
            <div class="results-card">
                <h2>Analysis Complete</h2>
                <p>Your Instagram insights:</p>
                
                <div class="stats">
                    <div class="stat">
                        <div class="stat-number">{{ $followersCount }}</div>
                        <div class="stat-label">Total Followers</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">{{ $followingCount }}</div>
                        <div class="stat-label">Total Following</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">{{ count($notFollowBack) }}</div>
                        <div class="stat-label">Not Following Back</div>
                    </div>
                </div>

                @if (count($notFollowBack) > 0)
                <div class="unfollowers-section">
                    <h3>Accounts Not Following Back</h3>
                    <div class="unfollowers-list">
                        @foreach ($notFollowBack as $user)
                        <div class="unfollower-item">
                            <div class="user-avatar">{{ strtoupper(substr($user, 0, 1)) }}</div>
                            <div class="user-name">{{ $user }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="action-buttons">
                        <form action="{{ route('download.pdf') }}" method="POST">
                            @csrf
                            <input type="hidden" name="followersCount" value="{{ $followersCount }}">
                            <input type="hidden" name="followingCount" value="{{ $followingCount }}">
                            @foreach ($notFollowBack as $user)
                                <input type="hidden" name="users[]" value="{{ $user }}">
                            @endforeach
                            <button type="submit" class="btn btn-primary">Download Report</button>
                        </form>
                        <button class="btn btn-secondary" onclick="window.location.reload()">New Analysis</button>
                    </div>
                </div>
                @else
                <div class="success-state">
                    <div class="success-icon">✓</div>
                    <h3>Perfect Engagement</h3>
                    <p>Everyone follows you back!</p>
                    <button class="btn btn-primary" onclick="window.location.reload()">New Analysis</button>
                </div>
                @endif
            </div>
            @endif
        </div>
    </section>

    <!-- Credit Section -->
    <section class="credit">
        <div class="container">
            <p>Crafted with precision by <span class="creator">nabilalopjake</span></p>
        </div>
    </section>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>