<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentInsertRequest;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CommentsController extends Controller
{
    public function store(CommentInsertRequest $request): JsonResponse
    {
        $user = User::firstOrCreate(
            [
                'email' => $request['email'],
            ],
            [
                'username' => $request['name'],
                'homepage' => $request['homepage'],
            ]
        );
        $user->comments()->create([
            'text' => $request['text'],
        ]);

        return response()->json(['message' => 'Comment has been created']);
    }

    public function list(Request $request): Response
    {
        $data = [];

        $comments = Comment::limit(15)->get();
        foreach($comments as $comment){
            $data['comments'][] = [
                'name' => $comment->user->username,
                'email' => $comment->user->email,
                'homepage' => $comment->user->homepage,
                'text' => $comment->text,
                'date' => Carbon::parse($comment->created_at)->format('d.m.Y H:i'),
            ];
        }
        return Inertia::render('Home', $data);
    }
}
