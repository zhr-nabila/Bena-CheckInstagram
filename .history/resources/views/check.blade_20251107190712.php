<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Unfollow Checker</title>
</head>
<body>
    <h2>Upload File Instagram JSON</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Followers JSON:</label>
        <input type="file" name="followers" accept=".json" required><br><br>

        <label>Following JSON:</label>
        <input type="file" name="following" accept=".json" required><br><br>

        <button type="submit">Proses</button>
    </form>

    @isset($followersCount)
        <h3>Hasil:</h3>
        <p>Total Followers: {{ $followersCount }}</p>
        <p>Total Following: {{ $followingCount }}</p>

        <p>Tidak Follow Balik:</p>
        @if(count($notFollowBack) > 0)
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
