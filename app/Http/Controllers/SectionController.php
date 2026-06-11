<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::withCount('words')->orderBy('name')->get();
        return view('sections.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:sections,name']);
        Section::create(['name' => $request->input('name')]);
        return redirect(url('/sections'))->with('success', 'セクションを追加しました');
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $request->validate(['name' => 'required|string|max:100|unique:sections,name,' . $id]);
        $section->update(['name' => $request->input('name')]);
        return redirect(url('/sections'))->with('success', 'セクションを更新しました');
    }

    public function destroy($id)
    {
        $section = Section::withCount('words')->findOrFail($id);
        if ($section->words_count > 0) {
            return redirect(url('/sections'))->with('error', 'このセクションには単語が存在します。先に単語を削除または移動してください。');
        }
        $section->delete();
        return redirect(url('/sections'))->with('success', 'セクションを削除しました');
    }
}
