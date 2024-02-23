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
            'reply_id' => $request['comment_id'],
        ]);

        return response()->json(['message' => 'Comment has been created']);
    }

    public function list(Request $request): Response
    {
        $data = [];

        $comments = Comment::limit(15)->where('reply_id',null)->get();
        foreach($comments as $comment){
            $data['comments'][] = $this->commentToData($comment);
        }
        return Inertia::render('Home', $data);
    }

    private function commentToData($comment){
        $data = [];
        $replies = [];
        if($comment->replies)
            foreach($comment->replies as $reply)
                $replies[] = $this->commentToData($reply);
        $data = [
            'id' => $comment->id,
            'name' => $comment->user->username,
            'email' => $comment->user->email,
            'homepage' => $comment->user->homepage,
            'text' => $comment->text,
            'date' => Carbon::parse($comment->created_at)->format('d.m.Y H:i'),
            'replies' => $replies,
        ];
        return $data;
    }
}
