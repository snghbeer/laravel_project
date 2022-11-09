<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;

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

}
