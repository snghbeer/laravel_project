<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\News;
use App\Models\Question;
use App\Models\FaqCategory;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyForm;

//admin users
class AdminDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getUsers()
    {
        //$usar = User::where('id', $id)->get();
        $users = User::all();

        return response()->json([
            'users' => $users,
        ]);
    }

    public function getUser($id)
    {
        //$usar = User::where('id', $id)->get();
        $user = DB::table('users')->where('id', $id)->first();

        //echo $req->id; //cannot echo as it can't toString() the object
        dd($user); //for testing purposes
    }


    public function updateRole($userId)
    {
        $user = User::find($userId);
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No user Found.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'role.required' => 'Role is required.'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'role' => 'required|integer|between:0,1',
        ], [
            'role.required' => 'Role is required.'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $user = User::find($id);
            if ($user) {

                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->role = $request->input('role');
                $user->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'User Updated Successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No user Found.'
                ]);
            }
        }
    }


    public function index()
    {
        $users = DB::table('users')->get();
        $messages = DB::table('contact_forms')->get();

        return view('admin.users', ['users' => $users, 'msg' => $messages]);
    }

    public function addNewsView()
    {
        return view('news.add');
    }

    public function addNews(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|max:191',
            'cover' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $news = new News();
            $coverPath = null;
            if ($req->hasFile('cover')) {
                $coverPath = $req->file('cover')->store('news', 'public');
                $news->cover = $coverPath;
            }
            $news->title = $req->title;
            $news->content = $req->content;
            $news->save();

            // dd($req);
            return redirect(route('home'));
        }
    }

    public function editNewsView($id)
    {
        $item = News::find($id);
        return view('news.edit', ['item' => $item]);
    }

    public function deleteItem($id)
    {
        $item = News::find($id);
        $item->forceDelete();
        return redirect(route('home'));
    }

    public function editNews(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|max:191',
            'cover' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $item = News::find($req->item_id);
            if ($item) {
                $coverPath = null;
                if ($req->hasFile('cover')) {
                    $coverPath = $req->file('cover')->store('news', 'public');
                    $item->cover = $coverPath;
                }
                $item->title = $req->title;
                $item->content = $req->content;
                $item->update();
                return redirect(route('home'));
            }
        }
    }

    public function addQuestionsView()
    {
        return view('faq.ask');
    }



    public function addQuestion(Request $req)
    {
        $catId = (int)$req->category;
        $cat = FaqCategory::find($catId);
        
        $validator = Validator::make($req->all(), [
            'category' => 'required',
            'question' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $question = new Question();
            $question->question = $req->question;
            if($req->input('answer')){
                $question->answer = $req->answer;
            }
            $question->category_id = $catId;
    
            $question->category()->associate($cat);
            $question->save();

            return redirect(route('admin.faqForm'));
        }
    }

    public function addCategory(Request $req){
        $validator = Validator::make($req->all(), [
            'category_name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }else{
            $cat = new FaqCategory();
            $cat->category_name = $req->category_name;
            $cat->save();
            return response()->json([
                'status' => 200,
                'message' => 'Category added successfully.'
            ]);
        }
    }

    public function getCategories(){
        $cats = FaqCategory::all();

        return response()->json([
            'users' => $cats,
        ]);
    }

    public function deleteCat($id)
    {
        $item = FaqCategory::find($id);
        $item->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully.'
        ]);
    }

    public function editFaqView($id)
    {
        $item = Question::find($id);
        return view('faq.edit', ['item' => $item]);
    }

    public function updateQuestion(Request $req)
    {
        $catId = (int)$req->category;
        $cat = FaqCategory::find($catId);
        
        $validator = Validator::make($req->all(), [
            'category' => 'required',
            'question' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $question = Question::find($req->item_id);
            $question->question = $req->question;
            if($req->input('answer')){
                $question->answer = $req->answer;
            }
            $question->category_id = $catId;
    
            $question->category()->associate($cat);
            $question->update();

            return redirect(route('faqView'));
        }
    }

    public function deleteQuestion($id)
    {
        $qst = Question::find($id);
        $qst->forceDelete();
        return redirect(route('faqView'));
    }

    public function getMsg($id){
        $msg = ContactForm::find($id);
        return response()->json([
            'item' => $msg,
        ]);
    }

    public function sendMail(Request $req){
        $reply = ContactForm::find($req->id);
        $reply->from = $req->from;
        $reply->answer = $req->reply;
        $reply->answered = true;
        $reply->update();
        Mail::to($req->to)->send(new ReplyForm($reply));
        return response()->json([
            'status' => 200,
            'message' => "Everything gucci!"
        ]);
    }
}
