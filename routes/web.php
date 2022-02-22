<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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











Route::get('livre/{id}/{slug}', 'LivreController@show')->name('livre.show');



Route::get('/categorie/{id}/{slug_cat}', 'CategorieController@show')->name('categorie.show');
Route::get('/livre-par', 'CategorieController@searchHome')->name('categorie.searchlivre');


Route::get('/auteur/{id}/{slug}', 'AuteurController@show')->name('auteur.show');
Route::get('/livreparA', 'AuteurController@searchHome')->name('auteur.searchlivre');

// home
/*
Route::get('/', function(){
    return view('Home');
});
*/


// promo
Route::get('/list-promo', 'PromoController@listpromo')->name('list.promo.home');



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// routes admin


Route::group(['prefix' => 'admin', 'middleware' => ['auth','isAdmin', 'prevent-back-history']], function(){
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('profile', 'AdminController@editprofile')->name('admin.profile');
    Route::post('update-profile-admin/{id}', 'AdminController@updateprofile_admin')->name('admin.profile-update');
    // livre

    Route::post('create_livre', 'LivreController@store')->name('livre.store');
    Route::delete('delete-livre/{id}', "LivreController@destroy")->name('livre.delete');
    Route::get('edit-livre/{id}', 'LivreController@edit')->name('livre.edit');
    Route::get('list-produits', 'LivreController@index')->name('livre.liste');
    Route::post('modifier-livre/{id}', 'LivreController@update')->name('livre.update');
    Route::get('prepare-livre', 'LivreController@getdata')->name('livre.get');
    Route::get('rechercher-livre', 'LivreController@search')->name('livre.search');

    // categorie
    Route::post('create_categorie', 'CategorieController@store')->name('categorie.store');
    Route::delete('delete_categorie/{id}', "CategorieController@destroy")->name('categorie.delete');
    Route::get('list-categories', 'CategorieController@index')->name('categorie.liste');
    Route::post('modifier-categorie/{id}', 'CategorieController@update')->name('categorie.update');
    Route::get('edit-categorie/{id}', 'CategorieController@edit')->name('categorie.edit');
    Route::get('rechercher-categorie', 'CategorieController@search')->name('categorie.search');
    // l'auteur

    Route::post('create_auteur', 'AuteurController@store')->name('auteur.store');
    Route::delete('delete_auteur/{id}', "AuteurController@destroy")->name('auteur.delete');
    Route::get('list-auteurs', 'AuteurController@index')->name('auteur.liste');
    Route::post('modifier-auteur/{id}', 'AuteurController@update')->name('auteur.update');
    Route::get('edit-auteur/{id}', 'AuteurController@edit')->name('auteur.edit');
    Route::get('rechercher-auteur', 'AuteurController@search')->name('auteur.search');

    //




    Route::get('list-produits/ajouter', function(){
        return view('ajouter');
    });


    //

    Route::get('parametre', 'PromoController@index')->name('parameter');

    //

    Route::post('ajouterPromo', 'PromoController@store')->name('promo.ajouter');
    Route::post('modifier-promo/{id}', 'PromoController@update')->name('promo.update');
    Route::get('edit-promo/{id}', 'PromoController@edit')->name('promo.edit');
    Route::delete('supprimer-promo/{id}', 'PromoController@destroy')->name('promo.supprimer');

    // commandes detail

    Route::get('commandes/nouvelles', 'CmdDetaiilController@index')->name('listc');
    Route::get('commandes/confirmer', 'CmdDetaiilController@cmd_conf')->name('listconf');
    Route::get('commandes/annuler', 'CmdDetaiilController@cmd_annuler')->name('listannuler');
    Route::get('commandes/livree', 'CmdDetaiilController@cmd_livree')->name('list.livree');
    Route::get('commandes/details/{id}', 'CmdDetaiilController@show')->name('commande.show');
    Route::get('commandes/details/edit-produit/{idcmd}/{id}', 'CmdDetaiilController@edit')->name('commande.edit');
    Route::post('commandes/details/update-produit/{idcmd}/{id}', 'CmdDetaiilController@update')->name('commande.update');
    Route::delete('commandes/details/delete-produit/{idcmd}/{id}', 'CmdDetaiilController@destroy')->name('produitcmd.delete');


    // commade

    Route::delete('delete-commande/{id}', 'CmdController@destroy')->name('commande.delete');
    Route::post('update-commande/{id}', 'CmdController@update')->name('detail.update');
    Route::put('annuler-commande/{id}', 'CmdController@annuler')->name('annuler.commande');
    Route::put('confirmer-commande/{id}', 'CmdController@confirmer')->name('confirmer.commande');
    Route::put('livree-commande/{id}', 'CmdController@livree')->name('livree.commande');

    // livreur

    Route::get('livreurs', 'LivreurController@index')->name('livreurs.list');
    Route::get('livreur/{id}', 'LivreurController@show')->name('livreur.show');
    Route::get('rechercher-livreur', 'LivreurController@search')->name('livreur.search');
    Route::post('ajouter-livreur', 'LivreurController@store')->name('livreur.ajouter');
    Route::delete('supprimer-livreur/{id}', 'LivreurController@destroy')->name('livreur.supprimer');

    // users

    Route::get('users', 'AdminController@get_users')->name('usersAdmin.list');
    Route::get('user/{id}', 'AdminController@show_user')->name('user.show');
    Route::get('users-search', 'AdminController@search_users')->name('usersAdmin.search');
    Route::post('user-ajouter', 'UserController@store')->name('user-ajouter');
    Route::put('user-as-admin/{id}', 'AdminController@make_admin')->name('make.admin');
    Route::put('remove-admin/{id}', 'AdminController@remove_admin')->name('remove.admin');
    Route::delete('remove-user/{id}', 'AdminController@remove_user')->name('remove.user');

    //----- reponse admin to user

    Route::post('reponse-to-user', 'AdminController@reponse_admin_to_user')->name('rep.admin');

    // message

    Route::get('list-messages', 'MessageController@index')->name('listm');
    Route::delete('msg-del/{id}', 'MessageController@destroy')->name('message.delete');
    Route::get('show-message/{id}', 'MessageController@show')->name('show.messageA');
    Route::get('show-message-env/{id}', 'MessageController@showenv')->name('show.messageEnv');
    Route::get('/messages-env', 'MessageController@msg_env')->name('msg.admin');
    Route::post('update-view-msg', 'MessageController@view_msg_update')->name('msg.update.view');


});


// route user

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'isUser', 'prevent-back-history']], function(){
    Route::get('profile', 'UserController@index')->name('user.profile');
    Route::get('edit-profile-user', 'UserController@editprofile')->name('user.profile-edit');
    Route::post('update-profile-user/{id}', 'UserController@updateprofile_user')->name('user.profile-update');
    //Route::get('mes-commandes', 'UserController@commandesUser')->name('user.commandes');
    Route::get('mes-messages', 'UserController@messagesUser')->name('user.messages');
    Route::get('mes-messages-env', 'UserController@msg_user_env')->name('user.messages.env');
    Route::get('show-message-user/{id}', 'UserController@showMessage_user')->name('show.message-user');
    Route::get('show-message-user-env/{id}', 'UserController@showMessage_user_env')->name('show.message-user-env');
    Route::post('reponse-to-admin', 'UserController@reponse_user_to_admin')->name('rep.user');
    Route::delete('msg-del-user/{id}', 'MessageController@destroy')->name('message-user.delete');
    Route::get('commandes/details-users/{id}', 'UserController@show_commande_user')->name('commande-user.show');

    // comment

    Route::post('add/comment', 'CommentController@store')->name('add.comment');
});


// cart

Route::get('/panier', 'CartController@cart')->name('panier.show');
Route::get('/delete-panier', 'CartController@remove')->name('panier.delete');

Route::post('/ajouter-au-panier', 'CartController@panier')->name('panier.ajouter');
Route::get('/update-panier', 'CartController@update')->name('panier.update');

Route::get('/panier-json', 'CartController@all')->name('panier.test');


// commande

Route::get('/final-cmd', 'CmdController@create')->name('cmd.create')->middleware('auth');
Route::post('/envoyer-cmd', 'CmdController@store')->name('cmd.envoyer')->middleware('auth');

Route::get('/commande-succee', function(){
    if(session()->has('nbcmd')){
    return view('success-cmd');
    }
    else{
        return redirect()->route('home');
    }
})->name('cmd.success');


// posts

Route::get('/livres',  [App\Http\Controllers\HomeController::class, 'showlivres'])->name('all.livre');
Route::get('/auteurs',  [App\Http\Controllers\HomeController::class, 'searchauteurs'])->name('all.auteur');
Route::get('/categories',  [App\Http\Controllers\HomeController::class, 'showcategories'])->name('all.categorie');
Route::get('search-livre',  [App\Http\Controllers\HomeController::class, 'searchlivres'])->name('allsearch.livre');
Route::get('search-auteur',  [App\Http\Controllers\HomeController::class, 'searchauteurs'])->name('allsearch.auteur');
Route::get('search-categorie',  [App\Http\Controllers\HomeController::class, 'searchcategories'])->name('allsearch.categorie');


// contact

Route::get('/contact', function(){
    return view('contact');
})->name('contact');


// send message

Route::post('/Envoyer-message', 'MessageController@store')->name('send')->middleware('auth', 'prevent-back-history');


Route::group(['middleware' => 'prevent-back-history'],function(){
    Auth::routes();

  });
