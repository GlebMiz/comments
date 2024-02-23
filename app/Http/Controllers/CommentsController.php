<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentInsertRequest;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CommentsController extends Controller
{
    public function store(CommentInsertRequest $request)
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
        $comment = $user->comments()->create([
            'text' => $request['text'],
            'reply_id' => $request['comment_id'],
        ]);

        if ($request->hasFile('image'))
            $this->addCommentFile($comment, $request->file('image'), 'image');
        if ($request->hasFile('file'))
            $this->addCommentFile($comment, $request->file('file'), 'file');

        return response()->json(['message' => 'Comment has been created']);
    }

    public function list(Request $request)
    {
        $page_qtty = 2;
        $page = $request['page'] ?: 1;
        [$filter, $order] = $this->orderFilters($request);

        $data = [];
        $comments = Comment::join('users', 'comments.user_id', 'users.id')
            ->select('users.username', 'users.email', 'comments.*')
            ->limit(15)
            ->where('reply_id', null)
            ->orderBy($filter, $order);

        $qtty = $comments->count();
        $comments = $comments->offset(($page - 1) * $page_qtty)->limit($page_qtty);

        $comments = $comments->get();
        foreach ($comments as $comment) {
            $data['comments'][] = $this->commentToData($comment);
        }
        $data['maxPage'] = ceil($qtty / $page_qtty);
        if (!isset($data['comments']) && $page > 1)
            return redirect()->to('/');
        return Inertia::render('Home', $data);
    }

    private function commentToData($comment)
    {
        $data = [];
        $replies = [];
        if ($comment->replies)
            foreach ($comment->replies as $reply)
                $replies[] = $this->commentToData($reply);
        $data = [
            'id' => $comment->id,
            'name' => $comment->user->username,
            'email' => $comment->user->email,
            'homepage' => $comment->user->homepage,
            'text' => $comment->text,
            'date' => Carbon::parse($comment->created_at)->format('d.m.Y H:i'),
            'files' => $comment->files->toArray(),
            'replies' => $replies,
        ];
        return $data;
    }

    private function orderFilters($request)
    {
        $valid_filters = [
            'name' => 'username',
            'email' => 'email',
            'date' => 'created_at'
        ];
        $valid_orders = [
            'up' => 'asc',
            'down' => 'desc'
        ];

        $filter = $request['filter'] && array_key_exists($request['filter'], $valid_filters) ? $valid_filters[$request['filter']] : 'created_at';
        $order = $request['order'] && array_key_exists($request['order'], $valid_orders) ? $valid_orders[$request['order']] : 'desc';

        return [$filter, $order];
    }

    private function addCommentFile($comment, $file, $type)
    {
        $path = $file->store('public');
        $name = $file->getClientOriginalName();
        
        $parts = explode("/", $path);
        $parts[0] = "storage";

        $path = implode("/", $parts);

        $comment->files()->create([
            'path' => $path,
            'name' => $name,
            'type' => $type,
        ]);
    }
}
