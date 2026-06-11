@extends('layouts.app')

@section('content')

<p><a href="{{ url('/sections') }}">← セクション一覧</a></p>

<div class="card">
    <h2>単語を追加</h2>
    <form method="POST" action="{{ url('/words') }}">
        @csrf
        <div>
            <label>セクション:</label>
            <select name="section_id" required>
                <option value="">選択してください</option>
                @foreach($sections as $s)
                    <option value="{{ $s->id }}" {{ $selectedSection == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>English:</label>
            <input type="text" name="english" required>
        </div>
        <div>
            <label>Japanese:</label>
            <input type="text" name="japanese" required>
        </div>
        <div style="margin-top:8px">
            <button type="submit">追加</button>
        </div>
    </form>
</div>

<div class="card">
    <h2>単語一覧</h2>

    <div style="margin-bottom:12px">
        <strong>セクション：</strong>
        <a href="{{ url('/words') }}" @class(['active' => !$selectedSection])>すべて</a>
        @foreach($sections as $s)
            <a href="{{ url('/words') }}?section={{ $s->id }}"
               style="margin-left:8px" @class(['active' => $selectedSection == $s->id])>{{ $s->name }}</a>
        @endforeach
    </div>

    @if($words->isEmpty())
        <p>単語が登録されていません。</p>
    @else
        <table>
            <thead><tr><th>Section</th><th>English</th><th>Japanese</th><th></th></tr></thead>
            <tbody>
            @foreach($words as $w)
                <tr>
                    <td>{{ $w->section->name }}</td>
                    <td>{{ $w->english }}</td>
                    <td>{{ $w->japanese }}</td>
                    <td>
                        <a href="{{ url('/words/' . $w->id . '/edit') }}">編集</a>
                        <form method="POST" action="{{ url('/words/' . $w->id) }}" style="display:inline; margin-left:8px">
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

    @if($selectedSection)
        <p style="margin-top:12px">
            <a href="{{ url('/quiz') }}?section={{ $selectedSection }}">このセクションのクイズを始める</a>
        </p>
    @endif
</div>

@endsection
