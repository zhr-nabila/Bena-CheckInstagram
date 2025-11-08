<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
<meta charset="UTF-8">
<title>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</title>
<link rel="stylesheet" href="{{ public_path('css/pdf-style.css') }}">
</head>
<body>

<h1>{{ $locale === 'id' ? 'Laporan Instagram Unfollowers' : 'Instagram Unfollowers Report' }}</h1>

<div class="summary">
    <strong>{{ $locale === 'id' ? 'Total Pengikut:' : 'Total Followers:' }}</strong> {{ $followersCount }}<br>
    <strong>{{ $locale === 'id' ? 'Total Mengikuti:' : 'Total Following:' }}</strong> {{ $followingCount }}<br>
    <strong>{{ $locale === 'id' ? 'Tidak Follow Balik:' : 'Not Following Back:' }}</strong> {{ count($notFollowBack) }}
</div>

@if(count($notFollowBack) > 0)
    <table>
        <thead>
            <tr>
                <th>{{ $locale === 'id' ? 'No' : 'No.' }}</th>
                <th>{{ $locale === 'id' ? 'Username' : 'Username' }}</th>
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
@else
    <div class="no-data">{{ $locale === 'id' ? 'Semua sudah follow balik' : 'Everyone follows you back' }}</div>
@endif

</body>
</html>