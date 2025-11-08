<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
    <style>
        /* Modern Simple PDF Style */
        :root {
            --primary: #FF69B4;
            --primary-light: #FF94B2;
            --text: #2D3748;
            --text-light: #718096;
            --border: #E2E8F0;
            --background: #FAF5FF;
        }

        @page {
            margin: 15mm;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: var(--text);
            background: white;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .container {
            max-width: 100%;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--text-light);
            font-size: 14px;
            font-weight: 400;
        }

        /* Stats Section - Modern */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 40px 0;
            text-align: center;
        }

        .stat-item {
            padding: 20px;
            position: relative;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 4px;
            display: block;
            line-height: 1;
        }

        .stat-item.highlight .stat-number {
            font-size: 42px;
        }

        .stat-label {
            color: var(--text-light);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 30px 0;
        }

        /* Content Section */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 20px;
        }

        /* Table Styling - Modern */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            border-bottom: 2px solid var(--primary);
        }

        th {
            color: var(--text);
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            font-weight: 500;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .number-cell {
            color: var(--text-light);
            font-weight: 600;
            width: 50px;
        }

        .username-cell {
            color: var(--text);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
            display: block;
        }

        .empty-text {
            font-size: 14px;
            font-weight: 500;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .generated-info {
            color: var(--text-light);
            font-size: 11px;
        }

        .credit {
            color: var(--text);
            font-size: 11px;
            font-weight: 500;
        }

        .credit strong {
            color: var(--primary);
        }

        /* Print Optimizations */
        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="brand">Bena</div>
            <h1 class="title">
                {{ $locale === 'id' ? 'Laporan Instagram' : 'Instagram Report' }}
            </h1>
            <p class="subtitle">
                {{ $locale === 'id' ? 'Analisis Unfollowers' : 'Unfollowers Analysis' }}
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
                <div class="stat-label">{{ $locale === 'id' ? 'Tidak Balik' : 'Not Following Back' }}</div>
            </div>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Content Section -->
        <div>
            <h2 class="section-title">
                {{ $locale === 'id' ? 'Akun yang Tidak Follow Balik' : 'Accounts Not Following Back' }}
            </h2>

            @if(count($notFollowBack) > 0)
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
            @else
                <div class="empty-state">
                    <span class="empty-icon">✨</span>
                    <div class="empty-text">
                        {{ $locale === 'id' ? 'Semua sudah follow balik!' : 'Everyone follows you back!' }}
                    </div>
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