<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
    <style>
        /* PDF Styles Simple & Clean */
        :root {
            --primary-pink: #FF94B2;
            --accent-pink: #FF69B4;
            --text-dark: #4A1E2A;
            --text-light: #8B5F6D;
            --border-light: #FFE4EC;
            --soft-pink: #FFF8FA;
        }

        @page {
            margin: 0;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: var(--text-dark);
            background: white;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .container {
            max-width: 100%;
            margin: 0;
            padding: 25mm 30mm;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-light);
        }

        .brand {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #FF94B2 0%, #FF69B4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }

        .title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .subtitle {
            color: var(--text-light);
            font-size: 11px;
            font-weight: 500;
        }

        /* Stats Section - SIMPLE */
        .stats-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 30px 0;
            text-align: center;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 4px;
            display: block;
            line-height: 1;
        }

        .stat-label {
            color: var(--text-light);
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .stat-item.highlight .stat-number {
            font-size: 32px;
        }

        /* Content Section */
        .content-section {
            margin: 35px 0;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-light);
        }

        /* Table Styling - CLEAN */
        .table-container {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: var(--soft-pink);
        }

        th {
            color: var(--text-dark);
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border-light);
        }

        td {
            padding: 10px 16px;
            border-bottom: 1px solid var(--border-light);
            font-size: 11px;
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
            color: var(--text-dark);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
            font-style: italic;
            border: 1px dashed var(--border-light);
            border-radius: 8px;
            background: var(--soft-pink);
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border-light);
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .generated-info {
            color: var(--text-light);
            font-size: 9px;
        }

        .credit {
            color: var(--text-dark);
            font-size: 9px;
        }

        .credit strong {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Print Optimizations */
        @media print {
            body {
                margin: 0;
                padding: 15mm;
            }
            
            .container {
                padding: 0;
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
                {{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}
            </h1>
            <p class="subtitle">
                {{ $locale === 'id' ? 'Analisis Akun Instagram Anda' : 'Your Instagram Account Analysis' }}
            </p>
        </div>

        <!-- Stats Section - SIMPLE -->
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