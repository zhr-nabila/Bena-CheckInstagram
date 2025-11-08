<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Unfollow Checker</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; }
        header { background-color: #1da1f2; color: white; padding: 40px 20px; text-align: center; }
        header h1 { margin: 0 0 10px; }
        .container { max-width: 700px; margin: 30px auto; padding: 0 20px; }
        h2 { text-align: center; margin-bottom: 20px; }
        form { margin-bottom: 30px; }
        label { display: block; margin-bottom: 5px; }
        input[type=file] { width: 100%; margin-bottom: 15px; }
        button { padding: 10px 20px; cursor: pointer; background-color: #1da1f2; color: white; border: none; border-radius: 4px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .scroll-table { max-height: 300px; overflow-y: auto; display: block; }
        .error { color: red; margin-bottom: 15px; }
        .note { background-color: #f9f9f9; border-left: 5px solid #1da1f2; padding: 10px; margin-bottom: 20px; }
        .download-btn { margin-top: 10px; display: inline-block; }
    </style>
</head>
<body>

<header>
    <h1>Instagram Unfollow Checker</h1>
    <p>Ketahui siapa yang tidak follow balik akunmu dengan mudah!</p>
</header>

<div class="container">

    <div class="note">
        <strong>Catatan:</strong><br>
        1. Download data followers & following dari Instagram (Format JSON).<br>
        2. Upload file JSON di bawah ini untuk mengecek unfollowers.<br>
        3. Setelah proses selesai, kamu bisa langsung download hasilnya.
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
        <h3>Hasil:</h3>
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
    @endisset

</div>
</body>
</html>
