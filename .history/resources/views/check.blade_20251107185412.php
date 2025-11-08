<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Unfollowers Instagram</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background: #f8f9fa; color: #333; }
        form { background: white; padding: 20px; border-radius: 10px; width: 400px; margin-bottom: 20px; }
        input[type=file] { display: block; margin: 10px 0; }
        button { background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .result { background: white; padding: 20px; border-radius: 10px; width: 400px; }
        ul { list-style: none; padding-left: 0; }
        li { padding: 5px 0; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>

<h2>Cek Unfollowers Instagram</h2>

@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="{{ route('check.process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Followers JSON:</label>
    <input type="file" name="followers" required>
    <label>Following JSON:</label>
    <input type="file" name="following" required>
    <button type="submit">Proses</button>
</form>

@if (isset($unfollowers))
<div class="result">
    <h3>Hasil:</h3>
    <p>Total Followers: {{ $followersCount }}</p>
    <p>Total Following: {{ $followingCount }}</p>
    <h4>Tidak Follow Balik:</h4>
    @if (count($unfollowers) > 0)
        <ul>
            @foreach ($unfollowers as $user)
                <li>{{ $user }}</li>
            @endforeach
        </ul>
    @else
        <p>Semua sudah follow balik 😎</p>
    @endif
</div>
@endif

</body>
</html>
