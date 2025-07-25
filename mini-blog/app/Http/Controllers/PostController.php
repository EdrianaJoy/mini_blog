<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
        'title' => 'required|string|max:255',
        'body'  => 'required|string',
    ]);

    auth()->user()->posts()->create($data);

    return redirect()->route('dashboard')->with('success','Post created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
       return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'body'  => 'required',
    ]);

    $post->update($data);

    return redirect()->route('dashboard')->with('success','Post Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
    $post->delete();

    return redirect()->route('dashboard')->with('success','Post deleted.');
    }
}
