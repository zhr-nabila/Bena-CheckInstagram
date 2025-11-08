<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.title')</title>
    <meta name="description" content="@lang('messages.description')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="app-header">
        <div class="logo-container">
            <a href="#" class="logo">Bena</a>
        </div>
        
        <div class="header-controls">
            <div class="language-switcher">
                <button class="lang-btn {{ session('locale', 'en') === 'en' ? 'active' : '' }}" data-lang="en">EN</button>
                <button class="lang-btn {{ session('locale', 'en') === 'id' ? 'active' : '' }}" data-lang="id">ID</button>
            </div>

            <button class="theme-toggle" aria-label="Toggle theme">
                <svg class="theme-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
                </svg>
            </button>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>@lang('messages.hero.title')</h1>
            <p>@lang('messages.hero.description')</p>
            
            <div class="premium-features">
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <h4>@lang('messages.features.accurate.title')</h4>
                        <p>@lang('messages.features.accurate.description')</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                        <h4>@lang('messages.features.premium.title')</h4>
                        <p>@lang('messages.features.premium.description')</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                            </svg>
                        </div>
                        <h4>@lang('messages.features.secure.title')</h4>
                        <p>@lang('messages.features.secure.description')</p>
                    </div>
                </div>
            </div>

            <a href="#upload" class="scroll-indicator">
                <span class="scroll-arrow"></span>
                {{ session('locale', 'en') === 'id' ? 'Mulai Analisis' : 'Start Analysis' }}
            </a>
        </div>
    </section>

    <section id="upload" class="section upload-section">
        <div class="container">
            <div class="upload-card">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                    </div>
                    <div class="upload-text">
                        <h3>@lang('messages.upload.title')</h3>
                        <p>@lang('messages.upload.description')</p>
                    </div>
                    <button class="upload-btn">@lang('messages.upload.button')</button>
                    <input type="file" class="file-input" accept=".json" multiple>
                    <p class="upload-hint">@lang('messages.upload.hint')</p>
                </div>

                <div class="file-list" id="fileList"></div>

                <form id="checkForm" action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                    @csrf
                    <input type="file" name="followers" class="file-input hidden" accept=".json" required>
                    <input type="file" name="following" class="file-input hidden" accept=".json" required>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" disabled>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 11.01L3 11v2h18v-2zM3 16h12v2H3v-2zM21 6H3v2.01L21 8V6z"/>
                            </svg>
                            <span>@lang('messages.upload.submit')</span>
                        </button>
                    </div>
                </form>

                <div class="loading" id="loading">
                    <div class="loading-spinner"></div>
                    <p>@lang('messages.analysis.loading')</p>
                </div>
            </div>

            @if (isset($followersCount))
            <div class="results-card visible">
                <h2>@lang('messages.analysis.complete')</h2>
                <p>@lang('messages.analysis.description')</p>
                
                <!-- CARD "NOT FOLLOWING BACK" SAJA -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ count($notFollowBack) }}</div>
                        <div class="stat-label">NOT FOLLOWING BACK</div>
                    </div>
                </div>

                @if (count($notFollowBack) > 0)
                <div class="unfollowers-section">
                    <h3>@lang('messages.results.title')</h3>
                    <div class="unfollowers-list">
                        @foreach ($notFollowBack as $user)
                        <div class="unfollower-item">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user, 0, 1)) }}
                            </div>
                            <div class="user-name">{{ $user }}</div>
                            <!-- TOMBOL UNFOLLOW -->
                            <a href="https://www.instagram.com/{{ $user }}/" 
                               target="_blank" 
                               class="unfollow-btn"
                               title="{{ session('locale', 'en') === 'id' ? 'Berhenti Mengikuti' : 'Unfollow' }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                                </svg>
                                <span>{{ session('locale', 'en') === 'id' ? 'Berhenti Mengikuti' : 'Unfollow' }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="btn-group">
                    <form action="{{ route('download.pdf') }}" method="POST" target="_blank">
                        @csrf
                        <input type="hidden" name="followersCount" value="{{ $followersCount }}">
                        <input type="hidden" name="followingCount" value="{{ $followingCount }}">
                        <input type="hidden" name="users" value="{{ json_encode($notFollowBack) }}">
                        <button type="submit" class="btn btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                            </svg>
                            <span>@lang('messages.results.download')</span>
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                        </svg>
                        <span>@lang('messages.results.new_analysis')</span>
                    </button>
                </div>
                @else
                <div class="success-state">
                    <div class="success-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <h3>@lang('messages.results.perfect')</h3>
                    <p>@lang('messages.results.perfect_description')</p>
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                        <span>@lang('messages.results.new_analysis')</span>
                    </button>
                </div>
                @endif
            </div>
            @endif
        </div>
    </section>

    <section class="credit-section">
        <div class="credit-content">
            <p class="credit-text">@lang('messages.credit')</p>
            <div class="creator-name">nabilalopjake</div>
        </div>
    </section>

    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        document.querySelectorAll('.lang-btn').forEach(button => {
            button.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');
                
                document.querySelectorAll('.lang-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                fetch('/switch-language/' + lang, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.reload();
                });
            });
        });
    </script>
</body>
</html>