<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@root')->name('root');
Route::get('products', 'ProductController@index')->name('products.index');
Route::get('products/{product}', 'ProductController@show')->name('products.show')->where(['product' => '[0-9]+']);

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('user_addresses', 'UserAddressController@index')->name('user_addresses.index');
    Route::get('user_addresses/create', 'UserAddressController@create')->name('user_addresses.create');
    Route::post('user_addresses', 'UserAddressController@store')->name('user_addresses.store');
    Route::get('user_addresses/{user_address}', 'UserAddressController@edit')->name('user_addresses.edit');
    Route::put('user_addresses/{user_address}', 'UserAddressController@update')->name('user_addresses.update');
    Route::delete('user_addresses/{user_address}', 'UserAddressController@destroy')->name('user_addresses.destroy');

    // Route::resource('products', 'ProductController', ['except' => ['index']]);
    Route::post('products/{product}/favorite', 'ProductController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductController@disfavor')->name('products.disfavor');
    Route::get('products/favorites', 'ProductController@favorites')->name('products.favorites');

    Route::post('cart', 'CartController@add')->name('cart.add');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');

    Route::post('orders', 'OrderController@store')->name('orders.store');
    Route::get('orders', 'OrderController@index')->name('orders.index');
    Route::get('orders/{order}', 'OrderController@show')->name('orders.show');
    Route::post('orders/{order}/received', 'OrderController@received')->name('orders.received');
    Route::get('orders/{order}/review', 'OrderController@review')->name('orders.review.show');
    Route::post('orders/{order}/review', 'OrderController@sendReview')->name('orders.review.store');

    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
});

Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
