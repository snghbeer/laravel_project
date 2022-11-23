<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\News;
use App\Models\FaqCategory;
use App\Models\ContactForm;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use NunoMaduro\Collision\Adapters\Phpunit\State;

class GuestController extends Controller
{
    public function index(){
        $news = News::all();
        return view('Dashboard.home', ['news' => $news]);
    }

    public function faqView(){
        $cats = FaqCategory::all();
        return view('faq.index', ['cats' => $cats]);
    }

    public function getCatQuestions($id){
        $questions = FaqCategory::find($id)->questions;
        return response()->json([
            'questions' => $questions,
        ]);
    }

    public function detailedNews($id){
        $item = News::find($id);
        return view('news.detailedNews', ['item' => $item]);
    }

    public function contactView(){
        return view('emails.form');
    }

    public function about(){
        return view('faq.about');
    }

    public function sendContactForm(Request $req){
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|max:191',
            'subject' => 'required|max:191',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else{
            $form = new ContactForm();
            $form->author = $req->email;
            $form->subject = $req->subject;
            $form->content = $req->content;
            $form->answer = '';
            $form->from = '';
            $form->save();
            return response()->json([
                'status' => 200,
                'message' => 'Your message has been sent!'
            ]);
        }
    }

    public function test(){

        $users = Storage::disk('public')->files('avatars');
        $files = Storage::disk('public')->files('news');
        $path = 'storage/' . $files[0];
        echo( '<img src="' . $path .'" alt="Responsive image">');
 /*       return response()->json([
            'files' => $files,
        ]); */
    }
}
