<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Grant every ability to admins before checking any other method.
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Any authenticated user can see the posts index (we’ll still scope
     * the results in the controller).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner (or an admin via before()) can view a single post.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Any authenticated user can create.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner (or an admin via before()) can update.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Only the owner (or an admin via before()) can delete.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * You can decide whether admins can restore—currently false.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * You can decide whether admins can force delete—currently false.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}