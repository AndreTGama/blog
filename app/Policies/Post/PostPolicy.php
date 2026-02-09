<?php

namespace App\Policies\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role?->name === 'admin' || $user->role?->name === 'editor';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        $idAdmin = $user->role?->name === 'admin';
        $idEditor = $user->role?->name === 'editor';
        $isAuthor = $post->author_id === $user->id;

        return $idAdmin || ($idEditor && $isAuthor);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        $idAdmin = $user->role?->name === 'admin';
        $idEditor = $user->role?->name === 'editor';
        $isAuthor = $post->author_id === $user->id;

        return $idAdmin || ($idEditor && $isAuthor);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        $idAdmin = $user->role?->name === 'admin';
        $idEditor = $user->role?->name === 'editor';
        $isAuthor = $post->author_id === $user->id;

        return $idAdmin || ($idEditor && $isAuthor);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->role?->name === 'admin';
    }
}
