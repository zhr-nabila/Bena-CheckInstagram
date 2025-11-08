<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instagram Unfollowers Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .user-list { margin: 20px 0; }
        .user-item { padding: 5px 0; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Instagram Unfollowers Report</h1>
        <p>Not Following Back: {{ count($notFollowBack) }} users</p>
    </div>
    
    <div class="user-list">
        <h2>Users Not Following Back:</h2>
        @foreach($notFollowBack as $user)
            <div class="user-item">{{ $user }}</div>
        @endforeach
    </div>
    
    <div class="footer">
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>