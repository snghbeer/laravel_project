<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\News;
use App\Models\FaqCategory;

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
}
