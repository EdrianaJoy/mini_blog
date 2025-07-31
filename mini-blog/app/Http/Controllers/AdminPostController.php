<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function approve(Post $post)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        $post->update(['status' => 'published']);

        return redirect()
            ->route('admin.dashboard', ['tab' => 0])
            ->with('success', 'Post approved.');
    }

    public function reject(Post $post)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        $post->update(['status' => 'deleted']);

        return redirect()
            ->route('admin.dashboard', ['tab' => 2])
            ->with('success', 'Post deleted.');
    }
}
