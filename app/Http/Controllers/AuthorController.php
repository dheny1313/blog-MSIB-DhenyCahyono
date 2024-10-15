<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        return view("authors.index", compact("authors"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|unique:categories|string|max:255',
            'address' => 'nullable|string',
        ]);

        try {
            Author::create($request->all());
            return redirect()->route('authors.index')->with('success', 'Author created successfully');
        } catch (\Exception $err) {
            return redirect()->route('authors.index')->with('error', $err->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view("authors.show", compact("author"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $author->update($request->all());
            return redirect()->route('authors.index')->with('success', 'at$author updated successfully');
        } catch (\Exception $err) {
            return redirect()->route('authors.index')->with('error', $err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Category deleted successfully');
    }
}
