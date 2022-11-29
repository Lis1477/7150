<?php

Route::get('/', 'MainPageController@index')->name('main-page');
Route::get('/category/{id}/{slug}', 'CategoryController@index')->name('category-page');
Route::get('/utsenionniye-tovary', 'CategoryController@discountedItems')->name('discounted-items');
Route::get('/noviye-tovary', 'CategoryController@newItems')->name('new-items');
Route::get('/tovar/{id}/{slug}', 'ItemController@index')->name('item-page');
Route::get('/cart', 'CartController@index')->name('cart-page');
Route::post('change-cart', 'CartController@changeCart')->name('change-cart');
Route::post('/promocode-activate', 'PromoCodeController@promoCodeActivate')->name('promocode-activate');
Route::post('/promocode-verify', 'PromoCodeController@promoCodeVerify');
Route::post('/order', 'OrderController@postOrder')->name('order');
Route::post('/one-click-order', 'OrderController@oneClickOrder')->name('one-click-order');
Route::any('/ajax-search', 'SearchController@search')->name('ajax-search');
Route::any('/search', 'SearchController@search')->name('get-search');
Route::get('/favorite-items', 'FavoriteItemController@index')->name('favorite-items-page');
Route::post('/change-favorite', 'FavoriteItemController@changeFavorite')->name('change-favorite');
Route::post('/callback', 'FeedbackController@callback');
Route::post('/feedback', 'FeedbackController@feedback');
Route::post('/want-cheaper', 'FeedbackController@wantСheaper');

Route::get('page/{slug}', 'SimplePageController@index');

Route::get('/novosty', 'NewsController@index')->name('news-page');
Route::get('/novost/{alias}', 'NewsController@showNews')->name('show-news');

Route::get('/brands', 'BrandController@index')->name('brands-page');
Route::get('/brand/{slug}', 'BrandController@getBrand')->name('show-brand');


Route::get('/policy', function() {return view('policy_page');});
Route::get('/public-offer', function() {return view('public_offer_page');});

Route::get('/error-no-page', 'ErrorController@page404');
Route::get('/error-page-mail', 'ErrorController@mail500');


Route::group(['middleware' => 'auth', 'namespace' => 'Cabinet', 'prefix' => 'cabinet'], function() {
	Route::get('profile', 'ProfileController@index')->name('view-profile');
	Route::get('history', 'HistoryController@index')->name('view-history');
	Route::post('profile-edit', 'ProfileController@editProfile');
	Route::post('add-address', 'ProfileController@addAddress');
	Route::post('update-address', 'ProfileController@updateAddress');
	Route::post('del-address', 'ProfileController@deleteAddress');
});

Auth::routes();
Route::post('/password/send', 'Auth\ForgotPasswordController@mailNewPassword');


// Route::get('/home', 'HomeController@index')->name('home');


// временные (одноразовые) роуты
Route::get('alfacat', 'CategoryFromAlfactok@index');
// Route::get('alfaitem', 'ItemsFromAlfactok@index');
// Route::get('alfabrand', 'BrandsFromAlfastok@index');

Route::get('cat-synchro', 'CategoryFromAlfactok@catSynchro');
// Route::get('item-synchro', 'ItemsFromAlfactok@itemSynchro');

