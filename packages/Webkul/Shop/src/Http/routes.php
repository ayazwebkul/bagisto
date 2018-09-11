<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'Webkul\Shop\Http\Controllers\HomeController@index')->defaults('_config', [
        'view' => 'shop::home.index'
    ]);

    Route::get('/categories/{slug}', 'Webkul\Shop\Http\Controllers\CategoryController@index')->defaults('_config', [
        'view' => 'shop::products.index'
    ])->name('shop.categories.index');

    Route::get('/products/{slug}', 'Webkul\Shop\Http\Controllers\ProductController@index')->defaults('_config', [
        'view' => 'shop::products.view'
    ])->name('shop.products.index');


    // Product Review routes
    Route::get('/reviews/{slug}', 'Webkul\Shop\Http\Controllers\ReviewController@index')->defaults('_config', [
        'view' => 'shop::products.reviews.index'
    ])->name('shop.reviews.index');

    Route::get('/reviews/create/{slug}', 'Webkul\Shop\Http\Controllers\ReviewController@create')->defaults('_config', [
        'view' => 'shop::products.reviews.create'
    ])->name('shop.reviews.create');

    Route::post('/reviews/create/{slug}', 'Webkul\Core\Http\Controllers\ReviewController@store')->defaults('_config', [
        'redirect' => 'admin.reviews.index'
    ])->name('admin.reviews.store');


    Route::view('/cart', 'shop::store.product.view.cart.index');

    // Route::view('/products/{slug}', 'shop::products.view');
    Route::post('/subscribe', 'Webkul\Shop\Http\Controllers\SubscribeController@send')->defaults('_config', [
        'view' => 'shop::home.index'
    ])->name('subscribewithus');
    //customer routes starts here
    Route::prefix('customer')->group(function () {

        // Login Routes
        Route::get('login', 'Webkul\Customer\Http\Controllers\SessionController@show')->defaults('_config', [
            'view' => 'shop::customers.session.index',
        ])->name('customer.session.index');

        Route::post('login', 'Webkul\Customer\Http\Controllers\SessionController@create')->defaults('_config', [
            'redirect' => 'customer.account.profile'
        ])->name('customer.session.create');

        // Registration Routes
        Route::get('register', 'Webkul\Customer\Http\Controllers\RegistrationController@show')->defaults('_config', [
            'view' => 'shop::customers.signup.index' //hint path
        ])->name('customer.register.index');

        Route::post('register', 'Webkul\Customer\Http\Controllers\RegistrationController@create')->defaults('_config', [
            'redirect' => 'customer.account.profile',
        ])->name('customer.register.create');   //redirect attribute will get changed immediately to account.index when account's index page will be made

        // Forget Password Routes
        Route::get('/forget-password', 'Webkul\Customer\Http\Controllers\ForgetPasswordController@create')->defaults('_config', [
            'view' => 'shop::customers.signup.forget-password'
        ])->name('customer.forget-password.create');

        Route::post('/forget-password', 'Webkul\Customer\Http\Controllers\ForgetPasswordController@store')->name('customer.forget-password.store');

        //Reset Password create
        Route::get('/reset-password/{token}', 'Webkul\Customer\Http\Controllers\ResetPasswordController@create')->defaults('_config', [
            'view' => 'shop::customers.signup.reset-password'
        ])->name('password.reset');

        Route::post('/reset-password', 'Webkul\Customer\Http\Controllers\ResetPasswordController@store')->defaults('_config', [
            'redirect' => 'customer.session.index'
        ])->name('customer.reset-password.store');

        //Route::get('/password-reset','Webkul\Customer\Http\Controllers\ForgetPasswordController@create')->defaults('_config', [
        //    'view' => 'shop::customers.signup.reset-password'
       // ])->name('password.reset');
        // Auth Routes
        Route::group(['middleware' => ['customer']], function () {

            //route for logout which will be under the auth guard of the customer by default
            Route::get('logout', 'Webkul\Customer\Http\Controllers\SessionController@destroy')->defaults('_config', [
                'redirect' => 'customer.session.index'
            ])->name('customer.session.destroy');

            //customer account
            Route::prefix('account')->group(function () {
                Route::get('profile', 'Webkul\Customer\Http\Controllers\CustomerController@profile')->defaults('_config', [
                'view' => 'shop::customers.account.profile.index'
                ])->name('customer.account.profile');

                //profile edit
                Route::get('profile/edit', 'Webkul\Customer\Http\Controllers\CustomerController@editProfile')->defaults('_config', [
                    'view' => 'shop::customers.account.profile.edit'
                ])->name('customer.profile.edit');
            });
        });
        //customer review routes starts here
        //Route::view('/reviews', 'shop::customers.account.reviews.review')->name('customer.account.reviews');
        Route::get('/reviews', 'Webkul\Customer\Http\Controllers\ReviewsController@index')->defaults('_config', [
            'view' => 'shop::customers.account.reviews.review'
            ])->name('customer.account.reviews');
        //customer review routes ends here
    });
    //customer routes end here

});
