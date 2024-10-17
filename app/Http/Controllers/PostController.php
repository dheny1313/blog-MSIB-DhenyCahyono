<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Author;
use App\Models\Post;
use GrahamCampbell\ResultType\Success;
use Illuminate\Database\Schema\PostgresSchemaState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'is_published'  => 'nullable|boolean',
            'category_id'   => 'required|exists:categories,id',
            'author_id'     => 'required|exists:authors,id',
        ]);

        try {
            $post = Post::findOrFail($id);
            $imagePath = $post->image; // Keep the existing image by default

            if ($request->hasFile('image')) {
                // If a new image is uploaded, delete the old image and store the new one
                Storage::disk('public')->delete($post->image);
                $imagePath = $request->file('image')->store('asset-images', 'public');
            }

            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imagePath, // Use the potentially updated image path
                'is_published' => $request->has('is_published') ? true : false,
                'category_id' => $request->category_id,
                'author_id' => $request->author_id,
            ]);

            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        } catch (\Exception $err) {
            return redirect()->route('posts.index')->with('error', $err->getMessage());
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

    public function show()
    {
        // Retrieve published posts with related category and author using Eloquent ORM
        $posts = Post::with(['category', 'author'])
            ->where('is_published', true)
            ->get();

        // Return the view with the posts data
        return view('welcome', compact('posts'));
    }
}
