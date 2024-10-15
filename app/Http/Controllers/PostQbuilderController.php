<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostQbuilderController extends Controller
{
    public function index()
    {
        // Menggunakan Query Builder dengan join ke tabel categories
        $posts = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.id', 'posts.title', 'posts.content', 'posts.image', 'posts.is_published', 'categories.id as category_id', 'categories.name as category_name')
            ->get();
        
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        // Mengambil semua kategori menggunakan Query Builder
        $categories = DB::table('categories')->get();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'is_published'  => 'nullable|boolean',
            'category_id'   => 'required|exists:categories,id',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('asset-images', 'public');
            }

            // Menggunakan Query Builder untuk insert data ke dalam tabel posts
            DB::table('posts')->insert([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imagePath,
                'is_published' => $request->is_published ?? false,
                'category_id' => $request->category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        } catch (\Exception $err) {
            return redirect()->route('posts.index')->with('error', $err->getMessage());
        }
    }

    public function edit($id)
    {
        // Menggunakan Query Builder untuk mendapatkan post berdasarkan ID
        $post = DB::table('posts')->where('id', $id)->first();

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'is_published'  => 'nullable|boolean',
            'category_id'   => 'required|exists:categories,id',
        ]);

        try {
            $post = DB::table('posts')->where('id', $id)->first();
            if (!$post) {
                return redirect()->route('posts.index')->with('error', 'Post not found');
            }

            $imagePath = $post->image;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('asset-images', 'public');
            }

            // Menggunakan Query Builder untuk update data
            DB::table('posts')->where('id', $id)->update([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imagePath,
                'is_published' => $request->is_published ?? false,
                'category_id' => $request->category_id,
                'updated_at' => now(),
            ]);

            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        } catch (\Exception $err) {
            return redirect()->route('posts.index')->with('error', $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Menggunakan Query Builder untuk menghapus data
            DB::table('posts')->where('id', $id)->delete();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
        } catch (\Exception $err) {
            return redirect()->route('posts.index')->with('error', $err->getMessage());
        }
    }
}
