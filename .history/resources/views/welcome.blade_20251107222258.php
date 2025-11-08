<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Unfollow Checker</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<button class="dark-mode-toggle" onclick="toggleDarkMode()">Dark Mode</button>
<header>
    <h1>Instagram Unfollow Checker</h1>
    <p>Temukan siapa saja yang tidak follow balik dengan cepat & mudah</p>
</header>

<div class="container">
    <div class="card">
        <form id="checkForm" action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="followers">Upload Followers JSON</label>
            <input type="file" name="followers" id="followers" required>

            <label for="following">Upload Following JSON</label>
            <input type="file" name="following" id="following" required>

            <button type="submit">Cek Sekarang</button>
        </form>
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Processing... Harap tunggu sebentar</p>
        </div>
    </div>

    @if(isset($followersCount))
    <div class="card result">
        <h2>Hasil Analisis</h2>
        <p><strong>Total Followers:</strong> {{ $followersCount }}</p>
        <p><strong>Total Following:</strong> {{ $followingCount }}</p>
        <p><strong>Tidak Follow Balik:</strong></p>
        @if(count($notFollowBack) > 0)
            <ul>
                @foreach($notFollowBack as $user)
                    <li>{{ $user }}</li>
                @endforeach
            </ul>
            <form action="{{ route('download.pdf') }}" method="POST">
    @csrf
    @foreach($notFollowBack as $user)
        <input type="hidden" name="users[]" value="{{ $user }}">
    @endforeach
    <input type="hidden" name="followersCount" value="{{ $followersCount }}">
    <input type="hidden" name="followingCount" value="{{ $followingCount }}">
    <button type="submit">Download PDF</button>
</form>

        @else
            <p>Semua sudah follow balik 😎</p>
        @endif
    </div>
    @endif
</div>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
