<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
    <style>
        /* PDF Styles dengan Tema Pink */
        :root {
            --primary-pink: #FF94B2;
            --secondary-pink: #FFB6C1;
            --accent-pink: #FF69B4;
            --dark-pink: #FF1493;
            --light-pink: #FFF0F5;
            --text-dark: #4A1E2A;
            --text-light: #8B5F6D;
            --bg-light: #FFF0F5;
            --border-light: #FFE4EC;
        }

        body {
            font-family: 'Inter', 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: var(--text-dark);
            background: white;
            margin: 0;
            padding: 20px;
        }
        
        /* Header */
        .pdf-header {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            padding: 25px 0;
            margin-bottom: 25px;
            text-align: center;
            border-radius: 10px;
        }

        .header-content h1 {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            color: white;
            font-size: 18px;
            font-weight: 700;
            opacity: 0.9;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            min-width: 120px;
            box-shadow: 0 4px 12px rgba(255, 105, 180, 0.15);
            border: 1px solid var(--border-light);
        }

        .stat-card.highlight {
            background: linear-gradient(135deg, var(--light-pink) 0%, var(--secondary-pink) 100%);
            border: 2px solid var(--accent-pink);
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(255, 148, 178, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        th {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
        }
        
        td {
            padding: 10px 15px;
            border-bottom: 1px solid var(--border-light);
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background: var(--light-pink);
        }

        tr:hover {
            background: rgba(255, 148, 178, 0.1);
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--text-light);
            font-style: italic;
            background: var(--light-pink);
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid var(--border-light);
        }
        
        /* Footer */
        .pdf-footer {
            border-top: 2px solid var(--border-light);
            padding: 20px 0;
            margin-top: 30px;
            text-align: center;
        }

        .footer-content {
            text-align: center;
        }

        .generated-info {
            color: var(--text-light);
            font-size: 10px;
            margin-bottom: 5px;
        }

        .credit {
            color: var(--text-dark);
            font-size: 10px;
        }

        .credit strong {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        @page {
            margin: 15mm;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .pdf-header {
                background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%) !important;
                -webkit-print-color-adjust: exact;
            }
            
            th {
                background: linear-gradient(135deg, var(--primary-pink) 0%, var(--accent-pink) 100%) !important;
                -webkit-print-color-adjust: exact;
            }
            
            .stat-card.highlight {
                background: linear-gradient(135deg, var(--light-pink) 0%, var(--secondary-pink) 100%) !important;
                -webkit-print-color-adjust: exact;
            }
        }
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
        <table>
            <thead>
                <tr>
                    <th>{{ $locale === 'id' ? 'No' : 'No.' }}</th>
                    <th>{{ $locale === 'id' ? 'Username' : 'Username' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notFollowBack as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>{{ $locale === 'id' ? '🎉 Semua Sudah Follow Balik!' : '🎉 Everyone Follows You Back!' }}</h3>
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
                {{ $locale === 'id' ? 'Dibuat dengan ❤️ oleh' : 'Created with ❤️ by' }} <strong>nabilalopjake</strong>
            </p>
        </div>
    </div>

</body>
</html>