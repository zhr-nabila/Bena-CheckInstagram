<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Unfollow Checker</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    *{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif;}
    body{background:#f0f2f5;color:#333;transition:background 0.3s,color 0.3s;}
    body.dark{background:#1e1e1e;color:#eee;}
    header{background:#007bff;color:white;padding:40px 20px;text-align:center;transition:background 0.3s;}
    body.dark header{background:#0d6efd;}
    header h1{font-size:2.5rem;margin-bottom:10px;}
    header p{font-size:1rem;opacity:0.9;}
    .container{max-width:700px;margin:-40px auto 40px auto;padding:20px;}
    .card{background:white;border-radius:12px;padding:25px;box-shadow:0 8px 20px rgba(0,0,0,0.1);transition:0.3s;}
    body.dark .card{background:#2b2b2b;box-shadow:0 8px 20px rgba(0,0,0,0.3);}
    .card:hover{box-shadow:0 12px 25px rgba(0,0,0,0.15);}
    form{display:flex;flex-direction:column;gap:15px;}
    label{font-weight:600;margin-bottom:5px;}
    input[type="file"]{padding:8px;border:1px solid #ccc;border-radius:8px;cursor:pointer;}
    body.dark input[type="file"]{background:#1e1e1e;color:#eee;border:1px solid #555;}
    button{padding:12px 20px;border:none;border-radius:8px;background:#007bff;color:white;font-weight:600;cursor:pointer;transition:0.2s;}
    button:hover{background:#0056b3;}
    .result{margin-top:30px;background:#f9fafb;border-left:5px solid #007bff;padding:20px;border-radius:10px;}
    body.dark .result{background:#2b2b2b;border-left:5px solid #0d6efd;}
    .result h2{margin-bottom:15px;color:#007bff;}
    body.dark .result h2{color:#0d6efd;}
    .result p{margin-bottom:10px;font-weight:500;}
    .result ul{padding-left:20px;list-style-type:disc;}
    .result ul li{padding:5px 0;}
    .loading{display:none;text-align:center;margin-top:20px;}
    .spinner{border:6px solid #f3f3f3;border-top:6px solid #007bff;border-radius:50%;width:40px;height:40px;animation:spin 1s linear infinite;margin:0 auto;}
    @keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
    .dark-mode-toggle{position:fixed;top:20px;right:20px;background:#007bff;color:white;padding:10px 15px;border:none;border-radius:8px;cursor:pointer;z-index:1000;}
    body.dark .dark-mode-toggle{background:#0d6efd;color:white;}
    @media(max-width:600px){header h1{font-size:2rem;}.card{padding:20px;}}
</style>
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
            <form action="{{ route('download.csv') }}" method="POST">
                @csrf
                @foreach($notFollowBack as $user)
                    <input type="hidden" name="users[]" value="{{ $user }}">
                @endforeach
                <button type="submit">Download CSV</button>
            </form>

            <form action="{{ route('download.pdf') }}" method="POST">
    @csrf
    <input type="hidden" name="followersCount" value="{{ $followersCount }}">
    <input type="hidden" name="followingCount" value="{{ $followingCount }}">
    @foreach($notFollowBack as $user)
        <input type="hidden" name="users[]" value="{{ $user }}">
    @endforeach
    <button type="submit">Download PDF</button>
</form>

        @else
            <p>Semua sudah follow balik 😎</p>
        @endif
    </div>
    @endif
</div>

<script>
    const form = document.getElementById('checkForm');
    const loading = document.getElementById('loading');

    form.addEventListener('submit', function(){
        loading.style.display = 'block';
    });

    function toggleDarkMode() {
        document.body.classList.toggle('dark');
    }
</script>
</body>
</html>
