@extends('layouts.app')

@section('content')

<div class="card">
    <h2>セクションを追加</h2>
    <form method="POST" action="{{ url('/sections') }}">
        @csrf
        <div>
            <label>セクション名:</label>
            <input type="text" name="name" required placeholder="例: TOEIC, 日常会話">
            <button type="submit" style="margin-left:8px">追加</button>
        </div>
        @error('name')
            <p style="color:red">{{ $message }}</p>
        @enderror
    </form>
</div>

<div class="card">
    <h2>セクション一覧</h2>
    @if($sections->isEmpty())
        <p>セクションが登録されていません。</p>
    @else
        <table>
            <thead>
                <tr><th>セクション名</th><th>単語数</th><th></th></tr>
            </thead>
            <tbody>
            @foreach($sections as $section)
                <tr>
                    <td>
                        <form method="POST" action="{{ url('/sections/' . $section->id) }}" style="display:inline-flex; gap:8px; align-items:center">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $section->name }}" required style="width:160px">
                            <button type="submit">更新</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ url('/words') }}?section={{ $section->id }}">{{ $section->words_count }}語</a>
                    </td>
                    <td>
                        <a href="{{ url('/quiz') }}?section={{ $section->id }}">クイズ</a>
                        <form method="POST" action="{{ url('/sections/' . $section->id) }}" style="display:inline; margin-left:8px">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
