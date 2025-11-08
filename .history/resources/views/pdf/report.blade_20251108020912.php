<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>
        @if(($locale ?? 'en') == 'id')
            Laporan Instagram Unfollowers Premium
        @else
            Premium Instagram Unfollowers Report
        @endif
    </title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --primary-color: #6366f1;
            --secondary-color: #4f46e5;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --bg-light: #f8fafc;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            margin: 0;
            padding: 2cm;
            background: white;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 2cm;
            padding-bottom: 1cm;
            border-bottom: 2px solid var(--border-color);
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5cm;
        }
        
        .title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.3cm;
        }
        
        .subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }
        
        .summary-section {
            margin-bottom: 1.5cm;
        }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5cm;
            padding-bottom: 0.3cm;
            border-bottom: 1px solid var(--border-color);
        }
        
        .summary-cards {
            display: flex;
            justify-content: space-between;
            gap: 0.5cm;
            margin-bottom: 0.5cm;
        }
        
        .summary-card {
            flex: 1;
            padding: 0.8cm 0.5cm;
            background: var(--bg-light);
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--border-color);
            position: relative;
        }
        
        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 12px 12px 0 0;
        }
        
        .summary-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.3cm;
            display: block;
        }
        
        .summary-label {
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5cm;
            font-size: 0.8rem;
        }
        
        th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            font-weight: 600;
            padding: 0.6cm 0.4cm;
            text-align: left;
            border: none;
        }
        
        td {
            padding: 0.4cm;
            border-bottom: 1px solid var(--border-color);
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
        }
        
        tr:nth-child(even) {
            background-color: var(--bg-light);
        }
        
        .no-data {
            text-align: center;
            padding: 1.5cm;
            color: var(--text-secondary);
            font-style: italic;
            background: var(--bg-light);
            border-radius: 12px;
            margin-top: 0.5cm;
            font-size: 1rem;
        }
        
        .footer {
            margin-top: 2cm;
            padding-top: 0.5cm;
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.7rem;
        }
        
        .generated-date {
            margin-bottom: 0.3cm;
            font-weight: 500;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">bena</div>
        <h1 class="title">
            @if(($locale ?? 'en') == 'id')
                Laporan Instagram Unfollowers Premium
            @else
                Premium Instagram Unfollowers Report
            @endif
        </h1>
        <p class="subtitle">
            @if(($locale ?? 'en') == 'id')
                Analisis canggih untuk lingkaran Instagram Anda
            @else
                Sophisticated analysis for your Instagram circle
            @endif
        </p>
        <div class="generated-date">
            {{ date('F j, Y') }}
        </div>
    </div>

    <div class="summary-section">
        <h2 class="section-title">
            @if(($locale ?? 'en') == 'id')
                Ringkasan Analisis
            @else
                Analysis Summary
            @endif
        </h2>
        
        <div class="summary-cards">
            <div class="summary-card">
                <span class="summary-number">{{ $followersCount }}</span>
                <div class="summary-label">
                    @if(($locale ?? 'en') == 'id')
                        Total Pengikut
                    @else
                        Total Followers
                    @endif
                </div>
            </div>
            <div class="summary-card">
                <span class="summary-number">{{ $followingCount }}</span>
                <div class="summary-label">
                    @if(($locale ?? 'en') == 'id')
                        Total Mengikuti
                    @else
                        Total Following
                    @endif
                </div>
            </div>
            <div class="summary-card">
                <span class="summary-number">{{ count($notFollowBack) }}</span>
                <div class="summary-label">
                    @if(($locale ?? 'en') == 'id')
                        Tidak Follow Balik
                    @else
                        Not Following Back
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(count($notFollowBack) > 0)
        <div class="results-section">
            <h2 class="section-title">
                @if(($locale ?? 'en') == 'id')
                    Akun yang Tidak Follow Balik
                @else
                    Accounts Not Following Back
                @endif
            </h2>
            
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            @if(($locale ?? 'en') == 'id')
                                Username
                            @else
                                Username
                            @endif
                        </th>
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
        </div>
    @else
        <div class="no-data">
            @if(($locale ?? 'en') == 'id')
                ✓ Semua akun sudah follow balik! Keseimbangan keterlibatan yang sempurna.
            @else
                ✓ All accounts are following you back! Perfect engagement balance.
            @endif
        </div>
    @endif

    <div class="footer">
        <div class="generated-date">
            @if(($locale ?? 'en') == 'id')
                Laporan dibuat oleh bena • Premium Instagram Analytics
            @else
                Report generated by bena • Premium Instagram Analytics
            @endif
        </div>
        <div>
            @if(($locale ?? 'en') == 'id')
                Dibuat dengan presisi oleh nabilalopjake
            @else
                Crafted with precision by nabilalopjake
            @endif
        </div>
    </div>
</body>
</html>