<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//ADMIN ROUTES
Route::prefix('admin')->middleware('auth', 'admin') -> group(function(){
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dash');
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/users', [AdminDashboardController::class, 'getUsers'])->name('users');
    Route::get('/user/{id}', [AdminDashboardController::class, 'getUser']);
    Route::get('/user/edit/{id}', [AdminDashboardController::class, 'updateRole'])->name('edit');
    Route::put('/update-user/{id}', [AdminDashboardController::class, 'update']);

    //Route::get('/user/demote/{id}', [AdminDashboardController::class, 'demote'])->name('demote');
   // Route::get('/user/update_role/{id}', [AdminDashboardController::class, 'updateRole'])->name('role');

    Route::get('/news/add', [AdminDashboardController::class, 'addNewsView'])->name('admin.addNews');
    Route::post('/news/add/post', [AdminDashboardController::class, 'addNews'])->name('admin.news.post');
    Route::get('/news/edit-page/{id}', [AdminDashboardController::class, 'editNewsView'])->name('editNewsView');
    Route::put('/news/edit/{id}', [AdminDashboardController::class, 'editNews'])->name('editNews');
    Route::delete('/news/delete/{id}', [AdminDashboardController::class, 'deleteItem'])->name('deleteItem');


    Route::get('/faq/ask', [AdminDashboardController::class, 'addQuestionsView'])->name('admin.faqForm');
    Route::post('/faq/ask/post', [AdminDashboardController::class, 'addQuestion'])->name('admin.ask');

    Route::get('/faq/categories', [AdminDashboardController::class, 'getCategories'])->name('admin.getCats');
    Route::post('/faq/category/add', [AdminDashboardController::class, 'addCategory'])->name('admin.addCat');
    Route::delete('/faq/category/delete/{id}', [AdminDashboardController::class, 'deleteCat'])->name('admin.deleteCat');
    Route::delete('/faq/question/delete/{id}', [AdminDashboardController::class, 'deleteQuestion'])->name('admin.deleteQst');
    Route::put('/faq/question/{id}/update', [AdminDashboardController::class, 'updateQuestion'])->name('updateQuestion');

    Route::get('/faq/edit-page/{id}', [AdminDashboardController::class, 'editFaqView'])->name('editFaqView');

});  



//Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dash');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
}); */
Route::prefix('profile')->middleware('auth') -> group(function(){
    Route::get('/{id}', [ProfileController::class, 'getProfile'])->name('profile');
    Route::get('/edit/{id}', [ProfileController::class, 'editProfile'])->name('editProfile');
    Route::put('/update/{id}', [ProfileController::class, 'updateProfile'])->name('updateProfile');
});  




Route::get('/', [GuestController::class, 'index'])->name('guest.dash');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/faq', [GuestController::class, 'faqView'])->name('faqView');
Route::get('/faq/ask', [HomeController::class, 'faqForm'])->name('faqForm');
Route::get('/faq/cat/{id}/questions', [GuestController::class, 'getCatQuestions'])->name('getCatQ');

Route::get('/dbtest', function () {
    return view('dbtest');
});
Route::get('/hello/{id}', function ($id) {
    return response('hello ' . $id);
}) -> where('id', '[0-9]');



Auth::routes();