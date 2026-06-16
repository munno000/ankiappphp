@extends('layouts.app')

@section('content')

@if($currentSection)
<div class="breadcrumb">
    <a href="{{ url('/books') }}">ブック一覧</a> &rsaquo;
    <a href="{{ url('/books/' . $currentSection->book_id . '/sections') }}">{{ $currentSection->book->name }}</a> &rsaquo;
    {{ $currentSection->name }}
</div>
@else
<div class="breadcrumb">
    <a href="{{ url('/books') }}">ブック一覧</a>
</div>
@endif

<div class="card">
    <h2>単語を追加</h2>
    <form method="POST" action="{{ url('/words') }}">
        @csrf
        <div class="form-row">
            <label>セクション</label>
            <select name="section_id" required>
                <option value="">選択してください</option>
                @foreach($sections as $s)
                    <option value="{{ $s->id }}" {{ $selectedSection == $s->id ? 'selected' : '' }}>
                        {{ $s->book->name }} &rsaquo; {{ $s->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label>English</label>
            <input type="text" name="english" required placeholder="例: apple">
        </div>
        <div class="form-row">
            <label>Japanese</label>
            <input type="text" name="japanese" required placeholder="例: りんご">
        </div>
        <button type="submit" class="btn btn-blue">追加する</button>
    </form>
</div>

<div class="card">
    <h2>単語一覧</h2>

    <div class="section-tabs">
        <a href="{{ url('/words') }}" @class(['section-tab', 'active' => !$selectedSection])>すべて</a>
        @foreach($sections as $s)
            <a href="{{ url('/words') }}?section={{ $s->id }}" @class(['section-tab', 'active' => $selectedSection == $s->id])>
                {{ $s->name }}
            </a>
        @endforeach
    </div>

    @if($words->isEmpty())
        <p style="color:#b0b8d0; text-align:center; padding:24px 0">単語が登録されていません</p>
    @else
        <table>
            <thead>
                <tr><th>Book / Section</th><th>English</th><th>Japanese</th><th>操作</th></tr>
            </thead>
            <tbody>
            @foreach($words as $w)
                <tr>
                    <td>
                        <span style="font-size:0.75rem; color:#b0b8d0">{{ $w->section->book->name ?? '' }}</span><br>
                        <span class="section-tab" style="padding:3px 10px; font-size:0.78rem">{{ $w->section->name }}</span>
                    </td>
                    <td style="font-weight:600">{{ $w->english }}</td>
                    <td>{{ $w->japanese }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ url('/words/' . $w->id . '/edit') }}" class="btn btn-outline btn-sm">編集</a>
                            <form method="POST" action="{{ url('/words/' . $w->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if($selectedSection)
        <div style="margin-top:20px; text-align:right">
            <a href="{{ url('/quiz') }}?section={{ $selectedSection }}" class="btn btn-pink">このセクションでクイズ →</a>
        </div>
    @endif
</div>

@endsection
