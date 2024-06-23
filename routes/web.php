<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use PHPUnit\Framework\Constraint\Count;

Route::get('/', function () {
    return view('welcome');
});


Route :: get ('/test/{name}', function ($name)
{
    return "hi ". $name;
});

Route ::get('/test/name/student' ,  array('as' => 'link' , function(){
    $url = route('link');
    return '' .$url;
}));

//Route::get('/user', 'App\Http\Controllers\UserController@index');
Route ::get('/user/{name}', [UserController ::class , 'index']);
Route::get('/post/{feed}', [UserController::class, 'create']);

Route::get('/insert', function(){
    DB::insert('insert into posts(title, content) values(?,?)',['all day','happy day']);
   
});

Route::get('/update', function(){
    DB::update(" update posts set title='my day'  where id=?", [1]);
});

Route::get('/select' , function(){
    $result = DB::select('select * from posts');
   // return $result;

   foreach ($result as $post){
    return  $post ->title;
   }
});

Route::get('/delete' , function(){
    DB::delete('delete from posts where id=?',[1]);
  //  DB::delete('delete users where name = ?', ['John'])
});

Route::get('/read' , function(){
   $post = Post::all();
   return $post; 
});

Route::get('/find', function(){
    $post = Post::find([3,4]);
    return $post;
});

Route::get('/findwhere', function(){
   $post =  Post::where('id',2)->get();
   return $post; 
});

Route::get('/eloinsert', function(){
   $post = new Post;
   $post -> title = "roth";
   $post ->  content ="pretty and smart";
   $post -> save(); 
});

Route::get('/elocreate', function(){
    Post::create(['title'=>'my future', 'content'=>'I am having it all'])->save();
});

Route::get('eloupdate', function(){
    $post = Post::find(4)->update(['title'=>'sireyrath', 'content'=>'pretty , smart, rich and elegant']);
});

Route::get('/elodelete', function(){
   Post::find(2)->delete(); 
//   $post = Post::find(1);
//   $post->delete();
//   return $post;
});


Route::get('/softdelete', function(){
    Post::find(3)->delete();
});

Route::get('/search', function(){
   $post  = Post::onlyTrashed()->where('is_admin','yes')->get();
   return $post; 
});

Route::get('/restore', function(){
   // Post::onlyTrashed()->restore();
   Post::onlyTrashed()->where('id',3)->restore();
});

Route::get('/forcedelete', function(){
   Post::onlyTrashed()->where('id',3)->forceDelete();
});


Route::get('/user/{$id}/post', function($id){
   
   return User::find($id)->post;
});

// Route::get('users/{id}', function($id){
//    return User::find($id) ;
// });



// one to one relationship
Route::get('/user/{id}/post', function($id){
    return User::find($id)->post;
});

Route::get('/post/{id}/user', function($id){
   return Post::find($id)->user; 
});
///////////////////////////////////////////////////////



// one to many relationship
Route::get('user    /{id}/posts/', function($id){
   return User::find($id)->posts; 
});

Route::get('/insert/post', function(){
    DB::insert('insert into posts(title, content,user_id) values(?,?,?)',['all day','happy day',2]);
   
});

Route::get('/update/post', function(){
   Post::find(3)->update(['title'=>'day 3']);

});
Route::get('eloupdate', function(){
    $post = Post::find(4)->update(['title'=>'sireyrath', 'content'=>'pretty , smart, rich and elegant']);
});
////////////////////////////////////



// insert data///////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/insert/user', function(){
    DB::insert('insert into users (name,email) values (?, ?)', ['mouyleng', 'noreak@gmail.com']);
    
});

Route::get('/insert/posts', function(){
    DB::insert('insert into posts (title,content ) values (?, ?)', ['day10', 'you are so pretty and smart ']);
    
});

Route::get('/insert/role', function(){
   // DB::insert('insert into roles (id, name) values (?, ?)', [2, 'editor']); 
    DB::insert('insert into roles (name) values ( ?)', ['viewer']); 
});

Route::get('/insert/role_user', function()
{
    DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [2, 2]);
});


// Many to many relationship
Route::get('/user/{id}/role', function($id){
   return User::find($id)->role; 
});

Route::get('/role/{id}/user', function($id){
    return Role::find($id)->user;
});



//// update user table ////////////////////////////////////////
Route::get('/country', function(){
  return  User::find(1)->update(['country_id'=>'1']) ;
});

Route::get('insert/country', function(){
   return DB::insert(' insert into countries (name) values(?)', ['singapore']);
  
});


// has many through relationship
Route::get('country/{id}/post', function ($id) {
    $country = Country::find($id);
    return $country ->posts ;
   
});