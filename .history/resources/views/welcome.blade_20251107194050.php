<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Unfollow Checker</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f7f7f7; }
        h1, h2 { text-align: center; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; }
        input[type="file"] { margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .result { margin-top: 20px; background: #e9ecef; padding: 15px; border-radius: 5px; }
        ul { padding-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Instagram Unfollow Checker</h1>
        <p>Download data followers & following dari Instagram, lalu upload di sini untuk cek siapa yang tidak follow balik.</p>

        <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Followers JSON:</label>
            <input type="file" name="followers" required>

            <label>Following JSON:</label>
            <input type="file" name="following" required>

            <button type="submit">Proses</button>
        </form>

        @if(isset($followersCount))
        <div class="result">
            <h2>Hasil:</h2>
            <p><strong>Total Followers:</strong> {{ $followersCount }}</p>
            <p><strong>Total Following:</strong> {{ $followingCount }}</p>
            <p><strong>Tidak Follow Balik:</strong></p>
            @if(count($notFollowBack) > 0)
                <ul>
                    @foreach($notFollowBack as $user)
                        <li>{{ $user }}</li>
                    @endforeach
                </ul>
            @else
                <p>Semua sudah follow balik 😎</p>
            @endif
        </div>
        @endif
    </div>
</body>
</html>
