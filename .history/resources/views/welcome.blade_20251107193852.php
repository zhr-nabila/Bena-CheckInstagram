<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Unfollow Checker</title>
<style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f9f9f9; margin: 0; padding: 0; }
    .container { max-width: 900px; margin: auto; padding: 20px; }
    h1 { text-align: center; color: #333; }
    .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    form { display: flex; flex-direction: column; gap: 15px; }
    input[type=file] { padding: 10px; border-radius: 6px; border: 1px solid #ccc; }
    button { padding: 12px; border: none; border-radius: 6px; background: #007bff; color: white; font-weight: bold; cursor: pointer; transition: 0.3s; }
    button:hover { background: #0056b3; }
    .results { margin-top: 20px; animation: fadeIn 1s ease-in; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
    th { background-color: #007bff; color: white; }
    @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }
</style>
</head>
<body>

<div class="container">
    <h1>Instagram Unfollow Checker</h1>

    <div class="card">
        <p>
            <strong>Cara pakai:</strong><br>
            1. Download data followers & following dari Instagram.<br>
            2. Upload file JSON di bawah ini.<br>
            3. Klik "Proses" untuk cek siapa yang tidak follow balik.
        </p>

        <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Followers JSON:</label>
            <input type="file" name="followers" required>

            <label>Following JSON:</label>
            <input type="file" name="following" required>

            <button type="submit">Proses</button>
        </form>
    </div>

    @if(isset($followersCount))
    <div class="card results" id="resultsCard">
        <h2>Hasil:</h2>
        <p><strong>Total Followers:</strong> {{ $followersCount }}</p>
        <p><strong>Total Following:</strong> {{ $followingCount }}</p>

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

            <form action="{{ route('download.csv') }}" method="POST" style="margin-top: 10px;">
                @csrf
                <input type="hidden" name="notFollowBack" value="{{ json_encode($notFollowBack) }}">
                <button type="submit">Download CSV</button>
            </form>
        @else
            <p>Semua sudah follow balik 😎</p>
        @endif
    </div>
    @endif
</div>

<script>
    // Scroll ke hasil otomatis setelah submit
    window.onload = function() {
        const results = document.getElementById('resultsCard');
        if(results) {
            results.scrollIntoView({behavior: 'smooth'});
        }
    };
</script>

</body>
</html>
