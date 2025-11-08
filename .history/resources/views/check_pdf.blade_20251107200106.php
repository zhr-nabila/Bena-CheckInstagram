<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Instagram Unfollowers Report</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; margin: 30px; background: #f0f2f5; color: #333; }
    h1 { text-align: center; margin-bottom: 10px; color: #007bff; }
    .summary { margin-top: 20px; font-size: 16px; padding: 15px; background: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #007bff; color: white; }
    td { background-color: #fafafa; }
    tr:nth-child(even) td { background-color: #f0f0f0; }
    .no-data { margin-top: 20px; font-size: 16px; font-style: italic; text-align: center; color: #555; }
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
