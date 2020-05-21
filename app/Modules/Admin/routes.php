<?php

Route::group(['middleware'=>['auth.admin']], function(){
	Route::get('/', function(){
        return redirect('/login');
    });

    Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard'], function(){
        Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);
    });

    Route::group(['namespace' => 'Role'], function(){
        Route::group(['prefix' => 'roles'], function(){
            Route::post('get-roles-data', array('as' => 'roles.datatables-index', 'uses' => 'RoleController@getRoleData'));
            Route::get('get-roles-select2', array('as' => 'roles.select2', 'uses' => 'RoleController@roleSelect2'));
        });
        Route::resource('roles', 'RoleController', [
            'names' => [
                'index' => 'roles.index',
                'create' => 'roles.create',
                'store' => 'roles.store',
                'edit' => 'roles.edit',
                'show' => 'roles.show',
                'update' => 'roles.update',
                'destroy' => 'roles.destroy'
            ]
        ]);
    });

    Route::group(['namespace' => 'User'], function(){
        Route::group(['prefix' => 'users'], function(){
            Route::post('get-users-data', array('as' => 'users.datatables-index', 'uses' => 'UserController@getUserData'));
            Route::get('/{hashid}/profile', array('as' => 'users.profile', 'uses' => 'UserController@show'));
            Route::put('/{hashid}/update-profile', array('as' => 'users.update-profile', 'uses' => 'UserController@updateProfile'));
        });
        Route::resource('users', 'UserController', [
            'names' => [
                'index' => 'users.index',
                'create' => 'users.create',
                'store' => 'users.store',
                'edit' => 'users.edit',
                'show' => 'users.show',
                'update' => 'users.update',
                'destroy' => 'users.destroy'
            ]
        ]);
    });

    Route::group(['namespace' => 'Article'], function(){
        Route::group(['prefix' => 'articles'], function(){
            Route::post('get-articles-data', array('as' => 'articles.datatables-index', 'uses' => 'ArticleController@getArticleData'));
        });
        Route::resource('articles', 'ArticleController', [
            'names' => [
                'index' => 'articles.index',
                'create' => 'articles.create',
                'store' => 'articles.store',
                'edit' => 'articles.edit',
                'show' => 'articles.show',
                'update' => 'articles.update',
                'destroy' => 'articles.destroy'
            ]
        ]);
    });
});