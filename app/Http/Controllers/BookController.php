<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Section;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::withCount('sections')->orderBy('name')->get();
        return view('books.index', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        Book::create(['name' => $request->input('name')]);
        return redirect(url('/books'))->with('success', 'ブックを追加しました');
    }

    public function edit(int $id)
    {
        $book = Book::findOrFail($id);
        $books = Book::orderBy('name')->get();
        $sections = Section::with('book')->orderBy('book_id')->orderBy('name')->get();
        return view('books.edit', compact('book', 'books', 'sections'));
    }

    public function update(Request $request, int $id)
    {
        $book = Book::findOrFail($id);
        $request->validate(['name' => 'required|string|max:100']);
        $book->update(['name' => $request->input('name')]);
        return redirect(url("/books/{$id}/edit"))->with('success', 'ブック名を更新しました');
    }

    public function updateSections(Request $request, int $id)
    {
        Book::findOrFail($id);

        $assignments = $request->input('sections', []);
        $bookIds = Book::pluck('id')->all();

        foreach ($assignments as $sectionId => $bookId) {
            if (in_array((int) $bookId, $bookIds)) {
                Section::where('id', $sectionId)->update(['book_id' => $bookId]);
            }
        }

        return redirect(url("/books/{$id}/edit"))->with('success', 'セクションの割り当てを更新しました');
    }

    public function destroy(int $id)
    {
        $book = Book::withCount('sections')->findOrFail($id);
        if ($book->sections_count > 0) {
            return redirect(url('/books'))->with('error', 'このブックにはセクションが存在します。先にセクションを移動または削除してください。');
        }
        $book->delete();
        return redirect(url('/books'))->with('success', 'ブックを削除しました');
    }
}
