<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>英単語暗記アプリ</title>
    <style>
        body{font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif; padding:20px}
        .container{max-width:800px;margin:0 auto}
        .card{border:1px solid #ddd;padding:16px;border-radius:6px;margin-bottom:12px}
        .success{color:green}
        .error{color:red}
    </style>
</head>
<body>
<div class="container">
    <h1>英単語暗記アプリ</h1>

    @if(session('success'))
        <div class="card success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="card error">{{ session('error') }}</div>
    @endif
    @if(session('result'))
        <div class="card">{{ session('result') }}</div>
    @endif

    @yield('content')
</div>
</body>
</html>
