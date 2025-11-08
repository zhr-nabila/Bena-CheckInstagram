<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Instagram Unfollowers Report</title>
<style>
    :root {
        --primary-color: #007bff;
        --bg-color: #f0f2f5;
        --card-bg: #ffffff;
        --text-color: #333333;
        --table-header-bg: #007bff;
        --table-header-color: #ffffff;
        --table-row-even: #f7f7f7;
        --shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    body {
        font-family: 'Inter', sans-serif;
        margin: 30px;
        background: var(--bg-color);
        color: var(--text-color);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: var(--primary-color);
    }

    .summary {
        background: var(--card-bg);
        padding: 20px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        font-size: 16px;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
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
        margin-top: 20px;
        font-size: 16px;
        color: #555;
    }
</style>
</head>
<body>
    <h1>Instagram Unfollowers Report</h1>

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
    <div class="no-data">Semua sudah follow balik 😎</div>
    @endif
</body>
</html>
