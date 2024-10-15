<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Author;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'author')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors    = Author::all();
        return view('posts.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'is_published'  => 'nullable|',
            'category_id'   => 'required|exists:categories,id',
            'author_id'   => 'required|exists:authors,id',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('asset-images', 'public');
            }

            Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imagePath,
                'is_published' => $request->has('is_published') ? true : false,
                'category_id' => $request->category_id,
                'author_id' => $request->author_id
            ]);
            return redirect()->route('posts.index')->with('success', 'Category created successfully');
        } catch (\Exception $err) {
            return redirect()->route('posts.index')->with('error', $err->getMessage());
        }
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('posts.edit', compact('post', "categories", "authors"));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Cek apakah ada file gambar yang di-upload
            if ($request->hasFile('image')) {
                // Hapus file gambar lama jika ada
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                // Simpan gambar baru
                $imagePath = $request->file('image')->store('asset-images', 'public');
                $post->image = $imagePath; // Set gambar baru ke dalam model
            }

            // Update data post tanpa menyertakan gambar jika tidak ada gambar baru
            $post->update($request->only('title', 'content', 'is_published', 'category_id'));

            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        } catch (\Exception $err) {
            return redirect()->route('posts.index')->with('error', 'Error updating post: ' . $err->getMessage());
        }
    }


    public function destroy(Post $post)
    {
        // Check if the post has an associated image
        if ($post->image) {
            // Delete the image from the public storage
            Storage::disk('public')->delete($post->image);
        }

        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    public function show(Post $post)
    {
        return view("posts.show", compact('post'));
    }
}
