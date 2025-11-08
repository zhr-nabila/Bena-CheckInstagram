<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Instagram Unfollowers Report</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; margin: 30px; }
    h1 { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #444; padding: 8px; text-align: left; }
    th { background-color: #f4f4f4; }
    .summary { margin-top: 20px; font-size: 16px; }
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
        <p>Semua sudah follow balik 😎</p>
    @endif
</body>
</html>
