<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Unfollowers Instagram</title>
</head>
<body>
    <h2>Cek Unfollowers Instagram</h2>

    @if(session('error'))
        <p style="color:red;">Error: {{ session('error') }}</p>
    @endif

    <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Followers JSON:</label>
        <input type="file" name="followers" accept=".json" required><br><br>

        <label>Following JSON:</label>
        <input type="file" name="following" accept=".json" required><br><br>

        <button type="submit">Proses</button>
    </form>

    @if (isset($followersCount))
        <hr>
        <h3>Hasil:</h3>
        <p><strong>Total Followers:</strong> {{ $followersCount }}</p>
        <p><strong>Total Following:</strong> {{ $followingCount }}</p>

        <h4>Tidak Follow Balik:</h4>
        @if (count($notFollowBack) > 0)
            <ul>
                @foreach ($notFollowBack as $user)
                    <li>{{ $user }}</li>
                @endforeach
            </ul>
        @else
            <p>Semua sudah follow balik 😎</p>
        @endif
    @endif
</body>
</html>
