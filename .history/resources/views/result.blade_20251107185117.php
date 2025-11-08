<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Unfollow Checker</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: left; }
        tr:nth-child(even) { background: #f9f9f9; }
        a { color: #007bff; text-decoration: none; }
        button { margin-top: 20px; padding: 10px 16px; background: #333; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Daftar Unfollowers ({{ $total }})</h2>

    @if(count($unfollowers) > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Link Profil</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unfollowers as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user }}</td>
                        <td><a href="https://www.instagram.com/{{ $user }}" target="_blank">Lihat Profil</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada unfollower ditemukan 🎉</p>
    @endif

    <form action="{{ route('upload.page') }}" method="GET">
        <button type="submit">Coba Lagi</button>
    </form>
</body>
</html>
