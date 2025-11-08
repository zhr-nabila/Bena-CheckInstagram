<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Unfollow Checker</title>
<style>
    /* Reset & general */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Helvetica', Arial, sans-serif; background: #f0f2f5; color: #333; }
    
    /* Header / Hero */
    header {
        background: linear-gradient(135deg,#405de6,#5851db,#833ab4,#c13584,#e1306c,#fd1d1d,#f56040,#f77737,#fcaf45,#ffdc80);
        color: white;
        text-align: center;
        padding: 60px 20px;
    }
    header h1 { font-size: 2.5rem; margin-bottom: 10px; }
    header p { font-size: 1.2rem; }

    /* Container */
    .container { max-width: 720px; margin: -40px auto 40px auto; background: white; padding: 30px 25px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }

    h2 { text-align: center; margin-bottom: 25px; color: #405de6; }
    .note { background: #eaf1ff; border-left: 5px solid #405de6; padding: 15px; margin-bottom: 25px; border-radius: 8px; font-size: 0.95rem; }

    form { display: flex; flex-direction: column; gap: 15px; margin-bottom: 30px; }
    label { font-weight: bold; }
    input[type=file] { padding: 8px; border-radius: 8px; border: 1px solid #ccc; }
    button { padding: 12px 20px; border: none; border-radius: 10px; background-color: #405de6; color: white; font-size: 1rem; cursor: pointer; transition: all 0.2s; }
    button:hover { background-color: #313ed0; }

    /* Table */
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #f3f3f3; }
    .scroll-table { max-height: 250px; overflow-y: auto; display: block; border-radius: 8px; }

    /* Error */
    .error { background: #ffe3e3; color: #d8000c; padding: 10px; border-radius: 8px; margin-bottom: 15px; }

    /* Download CSV button */
    .download-btn { margin-top: 15px; }
</style>
</head>
<body>

<header>
    <h1>Instagram Unfollow Checker</h1>
    <p>Lihat siapa yang tidak follow balik akunmu dengan cepat!</p>
</header>

<div class="container">

    <div class="note">
        <strong>Langkah-langkah:</strong><br>
        1. Download data <strong>Followers & Following</strong> dari Instagram (format JSON).<br>
        2. Upload file JSON di bawah ini.<br>
        3. Klik <strong>Proses</strong> untuk melihat hasil, dan bisa download CSV.
    </div>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Upload JSON Instagram</h2>
    <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Followers JSON:</label>
        <input type="file" name="followers" accept=".json" required>

        <label>Following JSON:</label>
        <input type="file" name="following" accept=".json" required>

        <button type="submit">Proses</button>
    </form>

    @isset($followersCount)
        <div class="result">
            <h2>Hasil</h2>
            <p><strong>Total Followers:</strong> {{ $followersCount }}</p>
            <p><strong>Total Following:</strong> {{ $followingCount }}</p>

            <p><strong>Tidak Follow Balik:</strong></p>
            @if(count($notFollowBack) > 0)
                <div class="scroll-table">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
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
                </div>

                <!-- Tombol download CSV -->
                <form action="{{ route('download.csv') }}" method="POST" class="download-btn">
                    @csrf
                    @foreach($notFollowBack as $user)
                        <input type="hidden" name="users[]" value="{{ $user }}">
                    @endforeach
                    <button type="submit">Download CSV</button>
                </form>
            @else
                <p>Semua sudah follow balik 😎</p>
            @endif
        </div>
    @endisset

</div>

</body>
</html>
