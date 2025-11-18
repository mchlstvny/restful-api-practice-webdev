<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * POST /api/books
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:books|max:20',
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'published_year' => 'required|integer|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book added successfully',
            'data' => $book
        ], 201);
    }

    /**
     * GET /api/books
     */
    public function index()
    {
        return response()->json(Book::all());
    }

    /**
     * GET /api/books/{id}
     * Menggunakan Route Model Binding → otomatis 404 jika tidak ditemukan
     */
    public function show(Book $book)
    {
        return response()->json($book);
    }

    /**
     * PATCH /api/books/{id}
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => ['sometimes', 'max:20', Rule::unique('books')->ignore($book->id)],
            'title' => 'sometimes|max:255',
            'author' => 'sometimes|max:255',
            'published_year' => 'sometimes|integer|max:' . date('Y'),
            'stock' => 'sometimes|integer|min:0',
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    /**
     * DELETE /api/books/{id}
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
