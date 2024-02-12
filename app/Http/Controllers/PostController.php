<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(User $user, Request $request)
    {
        $filters = $request->validate([
            'with_comments' => 'nullable|boolean',
        ]);

        $query = $user->posts();

        if ($filters['with_comments'] ?? false) {
            $query->with('comments', 'comments.user');
        }

        return PostResource::collection($query->get());
    }

    public function show(Post $post)
    {
        $post->load('comments');

        return PostResource::make($post);
    }
}
