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
    <!-- Language Toggle -->
    <button class="language-toggle">🇺🇸 EN</button>

    <!-- Theme Toggle -->
    <button class="theme-toggle">🌙</button>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="logo">bena</div>
            <h1>Discover Your True Instagram Circle</h1>
            <p>Uncover who's not following you back with our sophisticated analytics platform.</p>
            
            <!-- Features -->
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h4>Accurate Analysis</h4>
                    <p>Precise detection of non-reciprocal followers</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📄</div>
                    <h4>Premium Reports</h4>
                    <p>Beautiful PDF reports with insights</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h4>Secure & Private</h4>
                    <p>Your data never leaves your browser</p>
                </div>
            </div>

            <a href="#upload" class="scroll-indicator">Start Analysis</a>
        </div>
    </section>

    <!-- Upload Section -->
    <section id="upload" class="upload-section">
        <div class="container">
            <div class="upload-card">
                <div class="upload-area">
                    <div class="upload-icon">📁</div>
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
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" disabled>
                            <span>Upload Both Files to Continue</span>
                        </button>
                    </div>
                </form>

                <div class="loading" id="loading">
                    <div class="loading-spinner"></div>
                    <p>Analyzing your Instagram network...</p>
                </div>
            </div>

            @if (isset($followersCount))
            <!-- Results -->
            <div class="results-card">
                <h2>Analysis Complete</h2>
                <p>Your Instagram insights:</p>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $followersCount }}</div>
                        <div class="stat-label">Total Followers</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $followingCount }}</div>
                        <div class="stat-label">Total Following</div>
                    </div>
                    <div class="stat-card">
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

                    <div class="btn-group">
                        <form action="{{ route('download.pdf') }}" method="POST">
                            @csrf
                            <input type="hidden" name="followersCount" value="{{ $followersCount }}">
                            <input type="hidden" name="followingCount" value="{{ $followingCount }}">
                            @foreach ($notFollowBack as $user)
                                <input type="hidden" name="users[]" value="{{ $user }}">
                            @endforeach
                            <button type="submit" class="btn btn-primary">
                                <span>Download Report</span>
                            </button>
                        </form>
                        <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                            <span>New Analysis</span>
                        </button>
                    </div>
                </div>
                @else
                <div class="success-state">
                    <div class="success-icon">🎉</div>
                    <h3>Perfect Engagement</h3>
                    <p>Everyone follows you back!</p>
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                        <span>New Analysis</span>
                    </button>
                </div>
                @endif
            </div>
            @endif
        </div>
    </section>

    <!-- Credit -->
    <section class="credit-section">
        <div class="container">
            <p class="credit-text">Created by</p>
            <div class="creator-name">nabilalopjake</div>
        </div>
    </section>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>