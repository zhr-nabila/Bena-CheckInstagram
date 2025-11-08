<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
    <style>
        /* PDF Styles dengan Tema Pink yang Elegan */
        :root {
            --primary-pink: #FF94B2;
            --secondary-pink: #FFB6C1;
            --accent-pink: #FF69B4;
            --dark-pink: #FF1493;
            --light-pink: #FFF0F5;
            --soft-pink: #FFF8FA;
            --text-dark: #4A1E2A;
            --text-light: #8B5F6D;
            --border-light: #FFE4EC;
            --shadow-pink: 0 4px 20px rgba(255, 105, 180, 0.15);
        }

        @page {
            margin: 0;
        }

        body {
            font-family: 'Inter', 'DejaVu Sans', 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
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
            padding: 25px 30px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-light);
        }

        .brand {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, #FF94B2 0%, #FF69B4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .subtitle {
            color: var(--text-light);
            font-size: 12px;
            font-weight: 500;
        }

        /* Stats Section */
        .stats-section {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .stat-item {
            flex: 1;
            min-width: 120px;
            max-width: 140px;
            text-align: center;
            padding: 20px 15px;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-pink);
            border: 1.5px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
        }

        .stat-item.highlight {
            background: linear-gradient(135deg, var(--soft-pink) 0%, var(--light-pink) 100%);
            border: 2px solid var(--accent-pink);
            transform: scale(1.05);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 6px;
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

        /* Content Section */
        .content-section {
            margin: 35px 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 6px;
            height: 20px;
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            border-radius: 3px;
        }

        /* Table Styling */
        .table-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-pink);
            border: 1px solid var(--border-light);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
        }

        th {
            color: white;
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: none;
        }

        th:first-child {
            width: 60px;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-light);
            font-size: 11px;
            font-weight: 500;
            color: var(--text-dark);
        }

        tr:nth-child(even) {
            background: var(--soft-pink);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .number-cell {
            color: var(--text-light);
            font-weight: 600;
            text-align: center;
        }

        .username-cell {
            font-weight: 500;
            color: var(--text-dark);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 30px;
            background: linear-gradient(135deg, var(--soft-pink) 0%, var(--light-pink) 100%);
            border-radius: 16px;
            border: 2px dashed var(--border-light);
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }

        .empty-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-description {
            color: var(--text-light);
            font-size: 12px;
            max-width: 300px;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid var(--border-light);
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .generated-info {
            color: var(--text-light);
            font-size: 10px;
            font-weight: 500;
        }

        .credit {
            color: var(--text-dark);
            font-size: 10px;
            font-weight: 500;
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
            
            thead {
                background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%) !important;
            }
            
            .stat-item.highlight {
                background: linear-gradient(135deg, var(--soft-pink) 0%, var(--light-pink) 100%) !important;
            }
            
            .empty-state {
                background: linear-gradient(135deg, var(--soft-pink) 0%, var(--light-pink) 100%) !important;
            }
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .mb-0 { margin-bottom: 0; }
        .mt-0 { margin-top: 0; }
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
                <div class="stat-label">{{ $locale === 'id' ? 'PENGIKUT' : 'FOLLOWERS' }}</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $followingCount }}</span>
                <div class="stat-label">{{ $locale === 'id' ? 'MENGGUNAKAN' : 'FOLLOWING' }}</div>
            </div>
            <div class="stat-item highlight">
                <span class="stat-number">{{ count($notFollowBack) }}</span>
                <div class="stat-label">{{ $locale === 'id' ? 'TIDAK BALIK' : 'NOT FOLLOWING BACK' }}</div>
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
                                <th>#</th>
                                <th>{{ $locale === 'id' ? 'Username Instagram' : 'Instagram Username' }}</th>
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
                    <span class="empty-icon">🎉</span>
                    <h3 class="empty-title">
                        {{ $locale === 'id' ? 'Semua Sudah Follow Balik!' : 'Everyone Follows You Back!' }}
                    </h3>
                    <p class="empty-description">
                        {{ $locale === 'id' 
                            ? 'Akun Instagram Anda dalam kondisi yang sangat baik. Semua orang yang Anda ikuti juga mengikuti Anda kembali.' 
                            : 'Your Instagram account is in excellent condition. Everyone you follow follows you back.' 
                        }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="generated-info">
                    {{ $locale === 'id' ? 'Dibuat pada' : 'Generated on' }}: {{ now()->format('d M Y, H:i') }}
                </div>
                <div class="credit">
                    {{ $locale === 'id' ? 'Dibuatoleh' : 'Created with ❤️ by' }} <strong>nabilalopjake</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>