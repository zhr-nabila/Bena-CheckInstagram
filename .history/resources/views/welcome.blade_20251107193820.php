<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Unfollow Checker</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: auto; padding: 20px; }
        h1 { text-align: center; }
        form { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        button { padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>

<h1>Instagram Unfollow Checker</h1>

<p>
    Cara pakai: <br>
    1. Download data followers & following dari Instagram.<br>
    2. Upload file JSON di bawah ini.<br>
    3. Klik "Proses" untuk cek siapa yang tidak follow balik.
</p>

<form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Followers JSON:</label>
    <input type="file" name="followers" required><br><br>

    <label>Following JSON:</label>
    <input type="file" name="following" required><br><br>

    <button type="submit">Proses</button>
</form>

@if(isset($followersCount))
    <h2>Hasil:</h2>
    <p>Total Followers: {{ $followersCount }}</p>
    <p>Total Following: {{ $followingCount }}</p>

    @if(count($notFollowBack) > 0)
        <h3>Tidak Follow Balik:</h3>
        <table>
            <tr>
                <th>No</th>
                <th>Username</th>
            </tr>
            @foreach($notFollowBack as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user }}</td>
                </tr>
            @endforeach
        </table>

        <form action="{{ route('download.csv') }}" method="POST">
            @csrf
            <input type="hidden" name="notFollowBack" value="{{ json_encode($notFollowBack) }}">
            <button type="submit">Download CSV</button>
        </form>
    @else
        <p>Semua sudah follow balik 😎</p>
    @endif
@endif

</body>
</html>
