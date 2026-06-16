@extends('layouts.app')

@section('content')

<div class="card">
    <h2>ブックを追加</h2>
    <form method="POST" action="{{ url('/books') }}">
        @csrf
        <div class="form-row">
            <label>ブック名</label>
            <div style="display:flex; gap:10px">
                <input type="text" name="name" required placeholder="例: TOEIC 単語帳, 英検2級">
                <button type="submit" class="btn btn-blue" style="white-space:nowrap">追加</button>
            </div>
        </div>
        @error('name')
            <p style="color:#c0435a; font-size:0.85rem; margin-top:6px">{{ $message }}</p>
        @enderror
    </form>
</div>

<div class="card">
    <h2>ブック一覧</h2>
    @if($books->isEmpty())
        <p style="color:#b0b8d0; text-align:center; padding:24px 0">ブックがまだありません</p>
    @else
        <table>
            <thead>
                <tr><th>ブック名</th><th>セクション数</th><th>操作</th></tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>
                        <form method="POST" action="{{ url('/books/' . $book->id) }}" class="section-edit-form">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $book->name }}" required>
                            <button type="submit" class="btn btn-blue btn-sm">更新</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ url('/books/' . $book->id . '/sections') }}" class="section-tab" style="padding:4px 12px">
                            {{ $book->sections_count }}セクション
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ url('/books/' . $book->id . '/sections') }}" class="btn btn-pink btn-sm">開く</a>
                            <a href="{{ url('/books/' . $book->id . '/edit') }}" class="btn btn-outline btn-sm">編集</a>
                            <form method="POST" action="{{ url('/books/' . $book->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('「{{ $book->name }}」を削除しますか？')">削除</button>
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
