<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Unfollowers</title>
</head>
<body>
    <h2>Daftar Akun yang Tidak Follow Balik</h2>

    @if(count($unfollowers) > 0)
        <ul>
            @foreach($unfollowers as $user)
                <li>
                    <a href="https://www.instagram.com/{{ $user }}" target="_blank">
                        {{ $user }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada unfollowers ditemukan 🎉</p>
    @endif

    <a href="{{ route('upload.page') }}">Coba Lagi</a>
</body>
</html>
