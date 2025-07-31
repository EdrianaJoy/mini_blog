<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // guard
        abort_unless(auth()->user()->hasRole('admin'), 403);

        // pull three different lists via where(...)
        $allPosts     = Post::where('status','published')
                            ->latest()
                            ->paginate(10);

        $pendingPosts = Post::where('status','pending')
                            ->latest()
                            ->paginate(10);

        $deletedPosts = Post::where('status','deleted')
                            ->latest()
                            ->paginate(10);

        return view('admin.dashboard', compact('allPosts','pendingPosts','deletedPosts'));
    }
}
