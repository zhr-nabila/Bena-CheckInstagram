<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Unfollow Checker</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; color: #333; }
        header { background: #007bff; color: white; padding: 40px 20px; text-align: center; }
        header h1 { font-size: 2.5rem; margin-bottom: 10px; }
        header p { font-size: 1rem; opacity: 0.9; }

        .container { max-width: 700px; margin: -40px auto 40px auto; padding: 20px; }
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: 0.3s; }
        .card:hover { box-shadow: 0 12px 25px rgba(0,0,0,0.15); }

        form { display: flex; flex-direction: column; gap: 15px; }
        label { font-weight: 600; margin-bottom: 5px; }
        input[type="file"] { padding: 8px; border: 1px solid #ccc; border-radius: 8px; cursor: pointer; }
        button { padding: 12px 20px; border: none; border-radius: 8px; background: #007bff; color: white; font-weight: 600; cursor: pointer; transition: 0.2s; }
        button:hover { background: #0056b3; }

        .result { margin-top: 30px; background: #f9fafb; border-left: 5px solid #007bff; padding: 20px; border-radius: 10px; }
        .result h2 { margin-bottom: 15px; color: #007bff; }
        .result p { margin-bottom: 10px; font-weight: 500; }
        .result ul { padding-left: 20px; list-style-type: disc; }
        .result ul li { padding: 5px 0; }

        @media(max-width: 600px) {
            header h1 { font-size: 2rem; }
            .card { padding: 20px; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Instagram Unfollow Checker</h1>
        <p>Temukan siapa saja yang tidak follow balik dengan cepat & mudah</p>
    </header>

    <div class="container">
        <div class="card">
            <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="followers">Upload Followers JSON</label>
                <input type="file" name="followers" id="followers" required>

                <label for="following">Upload Following JSON</label>
                <input type="file" name="following" id="following" required>

                <button type="submit">Cek Sekarang</button>
            </form>
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
            @else
                <p>Semua sudah follow balik 😎</p>
            @endif
        </div>
        @endif
    </div>
</body>
</html>
