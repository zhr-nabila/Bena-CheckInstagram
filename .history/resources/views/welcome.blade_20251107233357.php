<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bena • Instagram Analytics</title>
    <meta name="description" content="Premium Instagram analytics tool to discover your true engagement circle">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Theme Toggle -->
    <button class="theme-toggle" aria-label="Toggle theme">
        <span class="theme-icon"></span>
    </button>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="logo">bena</div>
            <h1>Premium Instagram Analytics</h1>
            <p>Discover your true engagement circle with our sophisticated analysis tool. Private, secure, and beautifully designed.</p>
            <a href="#upload" class="scroll-indicator">
                <span class="scroll-arrow"></span>
                Begin Analysis
            </a>
        </div>
    </section>

    <!-- Upload Section -->
    <section id="upload" class="section upload-section">
        <div class="container">
            <div class="upload-card">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                    </div>
                    <div class="upload-text">
                        <h3>Upload Instagram Data</h3>
                        <p>Select your followers.json and following.json files exported from Instagram</p>
                    </div>
                    <button class="upload-btn">Choose Files</button>
                    <input type="file" class="file-input" accept=".json" multiple>
                    <p class="upload-hint">Drag & drop files or click to browse</p>
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
                    <p>Analyzing your Instagram network...</p>
                </div>
            </div>

            @if (isset($followersCount))
            <!-- Results Section -->
            <div class="results-card visible">
                <h2>Analysis Complete</h2>
                <p>Your Instagram engagement insights:</p>
                
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
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                            </svg>
                            <span>Download PDF Report</span>
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                        </svg>
                        <span>New Analysis</span>
                    </button>
                </div>
                @else
                <div class="success-state">
                    <div class="success-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <h3>Perfect Engagement Balance</h3>
                    <p>Your Instagram circle shows mutual following across all accounts.</p>
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