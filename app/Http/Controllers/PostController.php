<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post || $post->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to update this post.'
            ], 403); 
        }

        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post->update($request->only('title', 'content'));

        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post || $post->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to delete this post.'
            ], 403); 
        }

        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
