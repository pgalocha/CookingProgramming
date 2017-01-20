<?php

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
use App\User;
use App\Post;
use App\Comment;
Route::get('/user_posts',function (){
    return App\User::find(1);
    //Another way to create and inser into DB
    App\User::create(['name'=>'Zoe','email'=> 'zoe@gmail.com'
    ,'contact'=> '091234321','avatar'=>'default.jpg',
        'password'=>bcrypt('password')]);

    //Create new user and save on DB
    $newUser= new App\User();
    $newUser->name= " Pedro";
    $newUser->email= "Pedro@gmail.com";
    $newUser->contact="913333333";
    $newUser->password=bcrypt('teste');
    $newUser->avatar="default.jpg";
    $newUser->save();
    $newUserId=$newUser->id;
    $exstingUser= App\User::find($newUserId);
    $exstingUser->contact="913333334";
    $exstingUser->save();

    // Posts with tags and comments
    $posts= Post::with(['comments','tags'])->get();
    return $posts;
    $users=User::all();

    foreach ($users as $user){
        echo "<h1> {$user->name} </h1>";
        echo "<ul>";
        foreach ($user->posts as $post){
            echo "<li> {$post->title} </li>";

            if(count($post->tags)>0){
                echo "Tags:<ol>";
                foreach($post->tags as $tag){
                    echo "<li> {$tag->title} </li>";
                }
                echo "</ol>";
            }
        }
        echo "</ul>";
    }

});
Route::get('/', function () {
    return Redirect::to('/index.html');
});

Route::get('routes',function(){
\Artisan::call('route:list');
    return "<pre>".\Artisan::output();
});

Route::get('/posts/last/{n?}','PostController@last');
Route::get('/menuinfo', 'BlogController@getMenuInfo');
Route::get('/users/posts', 'UserController@getAllPosts');
Route::get('/comments', 'CommentController@getAll');
Route::get('/tags/posts', 'TagController@getAllWithPosts');


Route::group(['prefix'=> '/user'],function(){
    Route::get('/',function(){
        echo "user";
    });
    Route::get('/new',['as'=>'newUser',function(){
        $userProfile= route('profileUser',['id'=> 1,'name'=>'Pedro']);
        return "usuario criado com sucesso.
    <a href='$userProfile'>VerPerfil</a>'";
    }]);
    Route::get('/{id}/{name}/profile',
        ['as' => 'profileUser',function ($id, $name){
            return "Exibindo perfil de $id e $name";
        }]);

    Route::match(['get','post'],'/{name}/{id}', function ($name,$id){
        return "hello , $name : $id";
    })->where([
        'name' => '[A-Za-z]+',
    ]);
});
Route::get('/testelogin',['middleware'=>'auth', function () {
    return "Logged!";
}]);

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('user','UserController');

Route::get('/routes', function (){
    \Artisan::call('route:list');
    return "<pre>". \Artisan::output();
});
Route::get('/testeuser', 'UserController@index');

Route::get('/query',function(){
   $users=DB::table('users')->get();

    $posts= DB::table('posts')->join('users','users.id','=','posts.user_id')->
        select("users.name",'posts.title')->get();
    return $posts;
    //return $users;
});


Route::get('/getall','UserController@getAll');
