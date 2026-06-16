<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>英単語暗記アプリ</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Hiragino Kaku Gothic ProN', 'Meiryo', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e0f4ff 0%, #fff0f5 50%, #e8f8ff 100%);
            min-height: 100vh;
            color: #3d3d5c;
        }

        /* ヘッダー */
        header {
            background: linear-gradient(135deg, #89c9f0 0%, #f9afc2 100%);
            padding: 0;
            box-shadow: 0 4px 20px rgba(137, 201, 240, 0.4);
        }
        .header-inner {
            max-width: 860px;
            margin: 0 auto;
            padding: 28px 24px 22px;
        }
        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 2px 8px rgba(90, 140, 180, 0.4);
            letter-spacing: 0.05em;
        }
        header h1 span {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.85;
            margin-left: 10px;
        }

        /* ナビ */
        nav {
            background: rgba(255,255,255,0.45);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255,255,255,0.7);
        }
        .nav-inner {
            max-width: 860px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            gap: 4px;
        }
        nav a {
            display: inline-block;
            padding: 12px 20px;
            color: #5a7fa0;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.92rem;
            border-bottom: 3px solid transparent;
            transition: color 0.2s, border-color 0.2s;
        }
        nav a:hover { color: #d472a0; border-bottom-color: #f9afc2; }
        nav a.nav-active { color: #d472a0; border-bottom-color: #f9afc2; font-weight: 700; }

        /* コンテナ */
        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 32px 24px 60px;
        }

        /* フラッシュメッセージ */
        .flash {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.92rem;
            font-weight: 500;
        }
        .flash-success { background: #d4f5e9; color: #2e7d5e; border-left: 4px solid #5ecfa0; }
        .flash-error   { background: #ffe8ed; color: #c0435a; border-left: 4px solid #f9afc2; }
        .flash-result  { background: linear-gradient(135deg, #e0f4ff, #fff0f5); color: #5a5a8a; border-left: 4px solid #89c9f0; }

        /* カード */
        .card {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(137, 201, 240, 0.15), 0 2px 8px rgba(249, 175, 194, 0.1);
        }
        .card h2 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #5a7fa0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid;
            border-image: linear-gradient(90deg, #89c9f0, #f9afc2) 1;
        }

        /* フォーム要素 */
        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #8090b0;
            margin-bottom: 5px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        input[type="text"], select, input[type="password"] {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #daeeff;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #3d3d5c;
            background: rgba(255,255,255,0.85);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        input[type="text"]:focus, select:focus {
            border-color: #89c9f0;
            box-shadow: 0 0 0 3px rgba(137, 201, 240, 0.2);
        }
        .form-row { margin-bottom: 16px; }

        /* ボタン */
        .btn {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 50px;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            text-decoration: none;
            letter-spacing: 0.03em;
        }
        .btn:hover { transform: translateY(-2px); opacity: 0.92; }
        .btn:active { transform: translateY(0); }
        .btn-blue {
            background: linear-gradient(135deg, #6ab8e8, #89c9f0);
            color: #fff;
            box-shadow: 0 4px 14px rgba(106, 184, 232, 0.45);
        }
        .btn-pink {
            background: linear-gradient(135deg, #f4829e, #f9afc2);
            color: #fff;
            box-shadow: 0 4px 14px rgba(244, 130, 158, 0.4);
        }
        .btn-outline {
            background: transparent;
            color: #89a8c0;
            border: 2px solid #c8dff0;
        }
        .btn-outline:hover { background: #f0f8ff; }
        .btn-sm { padding: 6px 14px; font-size: 0.82rem; }
        .btn-danger {
            background: linear-gradient(135deg, #f4829e, #e86080);
            color: #fff;
            box-shadow: 0 4px 12px rgba(232, 96, 128, 0.35);
        }

        /* テーブル */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        thead th {
            background: linear-gradient(135deg, rgba(137,201,240,0.18), rgba(249,175,194,0.18));
            color: #7090b0;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 2px solid rgba(137,201,240,0.3);
        }
        tbody tr {
            border-bottom: 1px solid rgba(137,201,240,0.12);
            transition: background 0.15s;
        }
        tbody tr:hover { background: rgba(137,201,240,0.07); }
        tbody tr:last-child { border-bottom: none; }
        td { padding: 12px 14px; font-size: 0.93rem; vertical-align: middle; }

        /* セクションタブ */
        .section-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
        .section-tab {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.84rem;
            font-weight: 500;
            text-decoration: none;
            color: #8090b0;
            background: rgba(255,255,255,0.7);
            border: 1.5px solid #daeeff;
            transition: all 0.2s;
        }
        .section-tab:hover { border-color: #89c9f0; color: #5a8fb0; }
        .section-tab.active {
            background: linear-gradient(135deg, #89c9f0, #f9afc2);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 3px 10px rgba(137,201,240,0.4);
            font-weight: 700;
        }

        /* クイズカード */
        .quiz-word {
            font-size: 2.4rem;
            font-weight: 800;
            text-align: center;
            padding: 28px 0;
            background: linear-gradient(135deg, #5bacd8, #e06890);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.03em;
        }
        .quiz-section-label {
            text-align: center;
            font-size: 0.8rem;
            color: #b0b8d0;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* パンくず */
        .breadcrumb { margin-bottom: 20px; font-size: 0.85rem; color: #90a0b8; }
        .breadcrumb a { color: #6ab8e8; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        /* アクション行 */
        .actions { display: flex; gap: 8px; align-items: center; }

        /* セクション管理インライン編集 */
        .section-edit-form { display: flex; gap: 8px; align-items: center; }
        .section-edit-form input[type="text"] { width: 180px; }
    </style>
</head>
<body>
<header>
    <div class="header-inner">
        <h1>🌸 英単語暗記アプリ <span>Anki App</span></h1>
    </div>
</header>
<nav>
    <div class="nav-inner">
        <a href="{{ url('/books') }}" @class(['nav-active' => request()->is('books*')])>ブック</a>
        <a href="{{ url('/words') }}" @class(['nav-active' => request()->is('words*')])>単語一覧</a>
        <a href="{{ url('/quiz') }}" @class(['nav-active' => request()->is('quiz*')])>クイズ</a>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="flash flash-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">⚠️ {{ session('error') }}</div>
    @endif
    @if(session('result'))
        <div class="flash flash-result">{{ session('result') }}</div>
    @endif

    @yield('content')
</div>
</body>
</html>
