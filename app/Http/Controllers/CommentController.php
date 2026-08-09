<?php

namespace App\Http\Controllers;

class CommentController extends Controller
{
    //comment list
    public function commentList()
    {
        return view('admin.comment.list');
    }
}
