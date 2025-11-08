<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Instagram Unfollowers Report</title>
<link rel="stylesheet" href="{{ public_path('css/pdf-style.css') }}">
</head>
<body>
    <h1>Instagram Unfollowers Report</h1>

    <div class="summary">
        <p>Total Followers: {{ $followersCount }}</p>
        <p>Total Following: {{ $followingCount }}</p>
        <p>Tidak Follow Balik: {{ count($notFollowBack) }}</p>
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
