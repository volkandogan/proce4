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

/*Route::get('/', function () {
    return view('welcome');
});*/



Auth::routes();
  Route::get('/', 'IndexController@index');
//Route::get('/home', 'HomeController@index')->name('home');

  Route::match(['get','post'], '/admin','AdminController@login');
//category Listing page
  Route::get('/products/{url}','ProductsController@products');
//product detail page
  Route::get('/product/{url}','ProductsController@product');

  Route::match(['get','post'], '/add-cart','ProductsController@addtocart');

  //show product in cart
  Route::match(['get','post'], '/cart','ProductsController@cart');
  //cart delete product
  Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');
  //cart quantity update update
  Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCarQuantity');
  //User login regster page
  Route::get('/login-register','UsersController@userLoginRegister');

  //user register form submit
  Route::post('/user-register','UsersController@register');
  //user logout
  Route::get('/user-logout','UsersController@logout');

  //user login form submit
  Route::post('/user-login','UsersController@login');

  //Route::match(['get','post'], '/login-register','UsersController@register');
  //check email if already exist
  Route::match(['get','post'], '/check-email','UsersController@checkEmail');


Route::group(['middleware' =>['frontlogin']], function() {

  // Account
    Route::match(['get','post'], '/account','UsersController@account');
 //chech password
    Route::post('/check-user-pwd','UsersController@chkUserPassword');
 //Update password and Email
       Route::post('/update-user-pwd','UsersController@updatePassword');
// Checkout
   Route::match(['get','post'], '/checkout','ProductsController@checkout');
});

Route::group(['middleware' =>['auth']], function() {
  Route::get('/admin/dashboard','AdminController@dashboard');
  Route::get('/admin/settings','AdminController@settings');
  Route::get('/admin/check-pwd','AdminController@chkPassword');
  Route::match(['get','post'], '/admin/update-pwd','AdminController@updatePassword');
  //categories route for admin
  Route::match(['get','post'], '/admin/add-category','CategoryController@addCategory');
  Route::match(['get','post'],'/admin/edit-category/{id}', 'CategoryController@editCategory');
  Route::match(['get','post'],'/admin/delete-category/{id}', 'CategoryController@deleteCategory');
  Route::get('/admin/view-categories', 'CategoryController@viewCategories');

  //products routes
  Route::match(['get','post'], '/admin/add-product','ProductsController@addProduct');
  Route::get('/admin/view-products', 'ProductsController@viewProducts');
  Route::match(['get','post'], '/admin/edit_product/{id}','ProductsController@editProduct');
  Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
  Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');

  //prdoruct ldap_get_attributes
  Route::match(['get','post'], '/admin/add_attributes/{id}','ProductsController@addAttributes');

  //Banner side
    Route::match(['get','post'], '/admin/add-banner','BannersController@addBanner');
    Route::get('/admin/view-banners','BannersController@viewBanner');

});
//Route::get('/admin/dashboard','AdminController@dashboard');
Route::get('/logout','AdminController@logout');
