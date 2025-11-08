<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bena • Instagram Unfollow Checker</title>
    <meta name="description" content="Discover who doesn't follow you back on Instagram with bena's premium analytics tool">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Theme Toggle -->
    <button class="theme-toggle" aria-label="Toggle theme">
        <span class="theme-icon">🌙</span>
    </button>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="logo text-gradient">bena</div>
            <h1>Discover Your True Instagram Circle</h1>
            <p>Premium analytics to uncover who's not following you back. Simple, private, and beautifully designed.</p>
            <a href="#upload" class="scroll-indicator">
                <span class="scroll-arrow"></span>
                Explore Features
            </a>
        </div>
    </section>

    <!-- Upload Section -->
    <section id="upload" class="section upload-section">
        <div class="container">
            <div class="upload-card">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6C4.9 2 4.01 2.9 4.01 4L4 20C4 21.1 4.89 22 5.99 22H18C19.1 22 20 21.1 20 20V8L14 2Z" fill="white"/>
                            <path d="M16 18H8V16H16V18ZM16 14H8V12H16V14ZM13 9V3.5L18.5 9H13Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="upload-text">
                        <h3>Upload Your Instagram Data</h3>
                        <p>Select your followers.json and following.json files to begin analysis</p>
                    </div>
                    <button class="upload-btn">Choose Files</button>
                    <input type="file" class="file-input" accept=".json" multiple>
                    <p class="upload-hint">Drag & drop your files or click to browse</p>
                </div>

                <!-- File List -->
                <div class="file-list" id="fileList"></div>

                <!-- Upload Form -->
                <form id="checkForm" action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                    @csrf
                    <input type="file" name="followers" class="file-input hidden" accept=".json" required>
                    <input type="file" name="following" class="file-input hidden" accept=".json" required>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" disabled>
                            <span>Upload Files to Continue</span>
                        </button>
                    </div>
                </form>

                <!-- Loading State -->
                <div class="loading" id="loading">
                    <div class="loading-spinner"></div>
                    <p>Analyzing your Instagram data...</p>
                </div>
            </div>

            @if (isset($followersCount))
            <!-- Results Section -->
            <div class="results-card visible">
                <h2>Analysis Complete</h2>
                <p>Here's what we found in your Instagram network:</p>
                
                <!-- Statistics -->
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

                <!-- Unfollowers List -->
                @if (count($notFollowBack) > 0)
                <div class="unfollowers-section">
                    <h3>Accounts Not Following Back</h3>
                    <div class="unfollowers-list">
                        @foreach ($notFollowBack as $user)
                        <div class="unfollower-item">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user, 0, 1)) }}
                            </div>
                            <div class="user-name">{{ $user }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="btn-group">
                    <form action="{{ route('download.pdf') }}" method="POST">
                        @csrf
                        <input type="hidden" name="followersCount" value="{{ $followersCount }}">
                        <input type="hidden" name="followingCount" value="{{ $followingCount }}">
                        @foreach ($notFollowBack as $user)
                            <input type="hidden" name="users[]" value="{{ $user }}">
                        @endforeach
                        <button type="submit" class="btn btn-primary">
                            <span>Download PDF Report</span>
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                        <span>New Analysis</span>
                    </button>
                </div>
                @else
                <div class="success-state">
                    <div class="success-icon">🎉</div>
                    <h3>Perfect Engagement!</h3>
                    <p>Everyone you follow follows you back. Your Instagram circle is perfectly balanced.</p>
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                        <span>New Analysis</span>
                    </button>
                </div>
                @endif
            </div>
            @endif
        </div>
    </section>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>