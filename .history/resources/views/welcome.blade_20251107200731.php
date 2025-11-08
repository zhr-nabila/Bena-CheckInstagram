<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Unfollow Checker</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<button class="dark-mode-toggle">Dark Mode</button>

<header class="hero">
    <div class="hero-content">
        <h1>Instagram Unfollow Checker</h1>
        <p>Temukan siapa yang tidak follow balik dengan cepat & mudah</p>
        <a href="#upload-section" class="btn-primary">Mulai Sekarang</a>
    </div>
</header>

<main>
    <section id="upload-section" class="upload-section">
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
                    <form action="{{ route('download.csv') }}" method="POST">
                        @csrf
                        @foreach($notFollowBack as $user)
                            <input type="hidden" name="users[]" value="{{ $user }}">
                        @endforeach
                        <button type="submit" class="btn-secondary">Download CSV</button>
                    </form>
                @else
                    <p>Semua sudah follow balik 😎</p>
                @endif
            </div>
            @endif
        </div>
    </section>
</main>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
