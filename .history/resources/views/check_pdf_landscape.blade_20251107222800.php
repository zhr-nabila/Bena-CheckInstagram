<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Instagram Unfollowers Report</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    :root {
        --primary-color: #007bff;
        --bg-color: #f0f2f5;
        --card-bg: #ffffff;
        --text-color: #333333;
        --table-header-bg: #007bff;
        --table-header-color: #ffffff;
        --table-row-even: #f7f7f7;
        --shadow: 0 4px 10px rgba(0,0,0,0.1);
        --line-gradient: linear-gradient(90deg, #007bff, #00c6ff);
    }

    body {
        font-family: 'Inter', sans-serif;
        margin: 20px 30px;
        background: var(--bg-color);
        color: var(--text-color);
    }

    header {
        text-align: center;
        margin-bottom: 20px;
    }

    header img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-bottom: 5px;
    }

    h1 {
        margin: 0;
        font-size: 26px;
        color: var(--primary-color);
        font-weight: 700;
    }

    .line-underline {
        width: 120px;
        height: 4px;
        background: var(--line-gradient);
        margin: 8px auto 0 auto;
        border-radius: 2px;
    }

    .summary {
        background: var(--card-bg);
        padding: 15px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        font-size: 15px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow);
        table-layout: fixed;
        page-break-inside: auto;
    }

    th, td {
        padding: 10px 8px;
        text-align: left;
        word-wrap: break-word;
    }

    th {
        background-color: var(--table-header-bg);
        color: var(--table-header-color);
    }

    td {
        background-color: var(--card-bg);
    }

    tr:nth-child(even) td {
        background-color: var(--table-row-even);
    }

    .no-data {
        text-align: center;
        font-style: italic;
        margin-top: 15px;
        font-size: 15px;
        color: #555;
    }
</style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/instagram-logo.png') }}" alt="Instagram Logo">
        <h1>Instagram Unfollowers Report</h1>
        <div class="line-underline"></div>
    </header>

    <div class="summary">
        <strong>Total Followers:</strong> {{ $followersCount }}<br>
        <strong>Total Following:</strong> {{ $followingCount }}<br>
        <strong>Tidak Follow Balik:</strong> {{ count($notFollowBack) }}
    </div>

    @if(count($notFollowBack) > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>No</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            @foreach(array_chunk($notFollowBack, 2) as $pairIndex => $pair)
            <tr>
                <td>{{ $pairIndex*2 + 1 }}</td>
                <td>{{ $pair[0] ?? '' }}</td>
                <td>{{ isset($pair[1]) ? $pairIndex*2 + 2 : '' }}</td>
                <td>{{ $pair[1] ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">Semua sudah follow balik 😎</div>
    @endif
</body>
</html>
