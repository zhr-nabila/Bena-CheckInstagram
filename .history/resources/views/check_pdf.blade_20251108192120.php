<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        {!! file_get_contents(public_path('css/pdf-style.css')) !!}
    </style>
</head>
<body>

    <!-- Header -->
    <div class="pdf-header">
        <div class="header-content">
            <h1>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</h1>
            <div class="logo">Bena</div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $followersCount }}</div>
            <div class="stat-label">{{ $locale === 'id' ? 'TOTAL FOLLOWERS' : 'TOTAL FOLLOWERS' }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $followingCount }}</div>
            <div class="stat-label">{{ $locale === 'id' ? 'TOTAL FOLLOWING' : 'TOTAL FOLLOWING' }}</div>
        </div>
        <div class="stat-card highlight">
            <div class="stat-number">{{ count($notFollowBack) }}</div>
            <div class="stat-label">{{ $locale === 'id' ? 'TIDAK FOLLOW BALIK' : 'NOT FOLLOWING BACK' }}</div>
        </div>
    </div>

    <!-- User List -->
    @if(count($notFollowBack) > 0)
        <div class="users-section">
            <h2 class="section-title">
                {{ $locale === 'id' ? 'Daftar yang Tidak Follow Balik' : 'Users Not Following Back' }}
                <span class="count-badge">{{ count($notFollowBack) }}</span>
            </h2>
            
            <div class="users-grid">
                @foreach($notFollowBack as $index => $user)
                    <div class="user-card">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <div class="username">{{ $user }}</div>
                            <div class="user-handle">@{{ $user }}</div>
                        </div>
                        <div class="user-number">{{ $index + 1 }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🎉</div>
            <h3>{{ $locale === 'id' ? 'Semua Sudah Follow Balik!' : 'Everyone Follows You Back!' }}</h3>
            <p>{{ $locale === 'id' ? 'Akun Instagram Anda dalam kondisi yang sempurna.' : 'Your Instagram account is in perfect condition.' }}</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="pdf-footer">
        <div class="footer-content">
            <p class="generated-info">
                {{ $locale === 'id' ? 'Dibuat pada' : 'Generated on' }}: {{ now()->format('d M Y H:i') }}
            </p>
            <p class="credit">
                {{ $locale === 'id' ? 'Dibuat dengan' : 'Created with' }} ❤️ {{ $locale === 'id' ? 'oleh' : 'by' }} <strong>nabilalopjake</strong>
            </p>
        </div>
    </div>

</body>
</html>