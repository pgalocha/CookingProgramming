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

Route::get('/', function () {
    return view('welcome');
});
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
    return $users;

});
