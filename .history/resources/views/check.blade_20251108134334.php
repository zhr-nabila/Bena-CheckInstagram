<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Unfollow Checker</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <h2>Upload File Instagram JSON</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('process.data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Followers JSON:</label>
            <input type="file" name="followers" accept=".json" required><br><br>

            <label>Following JSON:</label>
            <input type="file" name="following" accept=".json" required><br><br>

            <button type="submit">Proses</button>
        </form>

        @isset($followersCount)
            <h3>Hasil:</h3>
            <p><strong>Total Followers:</strong> {{ $followersCount }}</p>
            <p><strong>Total Following:</strong> {{ $followingCount }}</p>

            <p><strong>Tidak Follow Balik:</strong></p>
            @if (count($notFollowBack) > 0)
                <div class="scroll-table">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notFollowBack as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Semua sudah follow balik 😎</p>
            @endif
        @endisset
    </div>
</body>

</html>
