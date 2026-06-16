<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(int $bookId)
    {
        $book = Book::findOrFail($bookId);
        $sections = Section::withCount('words')->where('book_id', $bookId)->orderBy('name')->get();
        return view('sections.index', compact('book', 'sections'));
    }

    public function store(Request $request, int $bookId)
    {
        Book::findOrFail($bookId);
        $request->validate([
            'name' => 'required|string|max:100|unique:sections,name,NULL,id,book_id,' . $bookId,
        ]);
        Section::create(['name' => $request->input('name'), 'book_id' => $bookId]);
        return redirect(url("/books/{$bookId}/sections"))->with('success', 'セクションを追加しました');
    }

    public function update(Request $request, int $bookId, int $id)
    {
        $section = Section::where('book_id', $bookId)->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:100|unique:sections,name,' . $id . ',id,book_id,' . $bookId,
        ]);
        $section->update(['name' => $request->input('name')]);
        return redirect(url("/books/{$bookId}/sections"))->with('success', 'セクションを更新しました');
    }

    public function destroy(int $bookId, int $id)
    {
        $section = Section::withCount('words')->where('book_id', $bookId)->findOrFail($id);
        if ($section->words_count > 0) {
            return redirect(url("/books/{$bookId}/sections"))->with('error', 'このセクションには単語が存在します。先に単語を削除してください。');
        }
        $section->delete();
        return redirect(url("/books/{$bookId}/sections"))->with('success', 'セクションを削除しました');
    }
}
