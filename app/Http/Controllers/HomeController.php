<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\News;
use App\Models\Comment;


//for normal users
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = News::all();
        /*if (!Auth::check()){
            return view('Dashboard.home');
        } */
        return view('Dashboard.home', ['news' => $news]);

        //return view('home');
    }

    public function faqForm()
    {
        return view('faq.ask');
    }

    public function addComment(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'comment' => 'required|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }else{
            $post = News::find($req->news_id);

            $comment = new Comment();
            $comment->author = $req->author;
            $comment->content = $req->comment;
            $comment->news_id = $req->news_id;
            $comment->post()->associate($post); //a comment belongs to 1 post
            $comment->save();
            return response()->json([
                'status' => 200,
                'message' => 'Comment added successfully.',
                'comment' => $comment
            ]);
        }
    }

    public function getComments($postId)
    {
        $comments = News::find($postId)->comments;
        return response()->json([
            'comments' => $comments,
        ]);
    }

}
