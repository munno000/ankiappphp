@extends('layouts.app')

@section('content')

<div class="breadcrumb">
    <a href="{{ url('/books') }}">ブック一覧</a> &rsaquo; {{ $book->name }}
</div>

<div class="card">
    <h2>セクションを追加</h2>
    <form method="POST" action="{{ url('/books/' . $book->id . '/sections') }}">
        @csrf
        <div class="form-row">
            <label>セクション名</label>
            <div style="display:flex; gap:10px">
                <input type="text" name="name" required placeholder="例: Section 1, Unit 1">
                <button type="submit" class="btn btn-blue" style="white-space:nowrap">追加</button>
            </div>
        </div>
        @error('name')
            <p style="color:#c0435a; font-size:0.85rem; margin-top:6px">{{ $message }}</p>
        @enderror
    </form>
</div>

<div class="card">
    <h2>セクション一覧</h2>
    @if($sections->isEmpty())
        <p style="color:#b0b8d0; text-align:center; padding:24px 0">セクションがまだありません</p>
    @else
        <table>
            <thead>
                <tr><th>セクション名</th><th>単語数</th><th>操作</th></tr>
            </thead>
            <tbody>
            @foreach($sections as $section)
                <tr>
                    <td>
                        <form method="POST" action="{{ url('/books/' . $book->id . '/sections/' . $section->id) }}" class="section-edit-form">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $section->name }}" required>
                            <button type="submit" class="btn btn-blue btn-sm">更新</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ url('/words') }}?section={{ $section->id }}" class="section-tab" style="padding:4px 12px">
                            {{ $section->words_count }}語
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ url('/words') }}?section={{ $section->id }}" class="btn btn-outline btn-sm">単語</a>
                            <a href="{{ url('/quiz') }}?section={{ $section->id }}" class="btn btn-pink btn-sm">クイズ</a>
                            <form method="POST" action="{{ url('/books/' . $book->id . '/sections/' . $section->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('「{{ $section->name }}」を削除しますか？')">削除</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
