<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
    <style>
        {!! file_get_contents(public_path('css/pdf-style.css')) !!}
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="brand">Bena</div>
            <h1 class="title">
                {{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}
            </h1>
            <p class="subtitle">
                {{ $locale === 'id' ? 'Analisis Akun Instagram Anda' : 'Your Instagram Account Analysis' }}
            </p>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-item">
                <span class="stat-number">{{ $followersCount }}</span>
                <div class="stat-label">{{ $locale === 'id' ? 'Pengikut' : 'Followers' }}</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $followingCount }}</span>
                <div class="stat-label">{{ $locale === 'id' ? 'Mengikuti' : 'Following' }}</div>
            </div>
            <div class="stat-item highlight">
                <span class="stat-number">{{ count($notFollowBack) }}</span>
                <div class="stat-label">{{ $locale === 'id' ? 'Tidak Follow Balik' : 'Not Following Back' }}</div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <h2 class="section-title">
                {{ $locale === 'id' ? 'Daftar Akun yang Tidak Follow Balik' : 'Accounts Not Following Back' }}
            </h2>

            @if(count($notFollowBack) > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th class="number-cell">#</th>
                                <th>{{ $locale === 'id' ? 'Username' : 'Username' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notFollowBack as $index => $user)
                                <tr>
                                    <td class="number-cell">{{ $index + 1 }}</td>
                                    <td class="username-cell">{{ $user }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    {{ $locale === 'id' ? 'Semua sudah follow balik! 🎉' : 'Everyone follows you back! 🎉' }}
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="generated-info">
                    {{ $locale === 'id' ? 'Dibuat pada' : 'Generated on' }} {{ now()->format('d M Y') }}
                </div>
                <div class="credit">
                    by <strong>nabilalopjake</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>