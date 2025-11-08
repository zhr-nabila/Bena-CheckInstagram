<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            color: #2d3748;
            margin-bottom: 30px;
            font-size: 24px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        
        .summary {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #4299e1;
        }
        
        .summary strong {
            color: #2d3748;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background: #4a5568;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 10px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        tr:nth-child(even) {
            background: #f7fafc;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #718096;
            font-style: italic;
            background: #f7fafc;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        @page {
            margin: 20mm;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .summary {
                background: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
            }
            
            th {
                background: #4a5568 !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <h1>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</h1>

    <div class="summary">
        <strong>{{ $locale === 'id' ? 'Total Pengikut:' : 'Total Followers:' }}</strong> {{ $followersCount }}<br>
        <strong>{{ $locale === 'id' ? 'Total Mengikuti:' : 'Total Following:' }}</strong> {{ $followingCount }}<br>
        <strong>{{ $locale === 'id' ? 'Tidak Follow Balik:' : 'Not Following Back:' }}</strong> {{ count($notFollowBack) }}
    </div>

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
        <div class="no-data">{{ $locale === 'id' ? 'Semua sudah follow balik' : 'Everyone follows you back' }}</div>
    @endif

</body>
</html>