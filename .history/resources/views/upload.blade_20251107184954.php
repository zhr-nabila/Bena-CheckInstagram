<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Unfollow Checker</title>
</head>
<body>
    <h2>Upload File Instagram JSON</h2>

    <form action="{{ route('check.unfollow') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Followers JSON:</label>
        <input type="file" name="followers" required><br><br>

        <label>Following JSON:</label>
        <input type="file" name="following" required><br><br>

        <button type="submit">Proses</button>
    </form>
</body>
</html>
