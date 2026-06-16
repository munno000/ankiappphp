@extends('layouts.app')

@section('content')

<div class="breadcrumb">
    <a href="{{ url('/books') }}">ブック一覧</a> &rsaquo; {{ $book->name }}
</div>

{{-- ブック名編集 --}}
<div class="card">
    <h2>ブック名を編集</h2>
    <form method="POST" action="{{ url('/books/' . $book->id) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>ブック名</label>
            <div style="display:flex; gap:10px">
                <input type="text" name="name" value="{{ $book->name }}" required>
                <button type="submit" class="btn btn-blue" style="white-space:nowrap">更新</button>
            </div>
        </div>
    </form>
</div>

{{-- セクション割り当て --}}
<div class="card">
    <h2>セクションの割り当て</h2>

    @if($sections->isEmpty())
        <p style="color:#b0b8d0; text-align:center; padding:24px 0">セクションがまだありません</p>
    @else
        <form method="POST" action="{{ url('/books/' . $book->id . '/sections') }}">
            @csrf
            @method('PUT')

            <table>
                <thead>
                    <tr>
                        <th>セクション名</th>
                        <th>単語数</th>
                        <th>所属ブック</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($sections as $section)
                    <tr @class(['highlight' => $section->book_id === $book->id])>
                        <td style="font-weight: {{ $section->book_id === $book->id ? '600' : '400' }}">
                            {{ $section->name }}
                        </td>
                        <td style="color:#b0b8d0">{{ $section->words->count() }}語</td>
                        <td>
                            <select name="sections[{{ $section->id }}]" class="book-select"
                                data-current="{{ $section->book_id }}"
                                data-target="{{ $book->id }}">
                                @foreach($books as $b)
                                    <option value="{{ $b->id }}" {{ $section->book_id === $b->id ? 'selected' : '' }}>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top:20px; display:flex; gap:10px; justify-content:flex-end">
                <a href="{{ url('/books') }}" class="btn btn-outline">キャンセル</a>
                <button type="submit" class="btn btn-pink">割り当てを保存</button>
            </div>
        </form>
    @endif
</div>

<style>
    tr.highlight td { background: rgba(137,201,240,0.08); }
    .book-select {
        padding: 6px 10px;
        border-radius: 8px;
        border: 2px solid #daeeff;
        font-size: 0.88rem;
        color: #3d3d5c;
        background: rgba(255,255,255,0.85);
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .book-select:focus { border-color: #89c9f0; outline: none; }
    .book-select.changed { border-color: #f9afc2; background: #fff5f8; }
</style>

<script>
    document.querySelectorAll('.book-select').forEach(function(select) {
        select.addEventListener('change', function() {
            this.classList.toggle('changed', this.value !== this.dataset.current);
        });
    });
</script>

@endsection
