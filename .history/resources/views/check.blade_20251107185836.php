<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Unfollowers Instagram</title>
</head>
<body>
    <h2>Cek Unfollowers Instagram</h2>

    <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Followers JSON:</label>
        <input type="file" name="followers" required><br><br>

        <label>Following JSON:</label>
        <input type="file" name="following" required><br><br>

        <button type="submit">Proses</button>
    </form>

    @isset($followersCount)
        <h3>Hasil:</h3>
        <p>Total Followers: {{ $followersCount }}</p>
        <p>Total Following: {{ $followingCount }}</p>

        @if(count($notFollowBack) > 0)
            <h4>Tidak Follow Balik:</h4>
            <ul>
                @foreach($notFollowBack as $user)
                    <li>{{ $user }}</li>
                @endforeach
            </ul>
        @else
            <p>Semua sudah follow balik 😎</p>
        @endif
    @endisset
</body>
</html>
