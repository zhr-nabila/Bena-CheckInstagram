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
    <div class="no-data">Semua sudah follow balik</div>
@endif

</body>
</html>
