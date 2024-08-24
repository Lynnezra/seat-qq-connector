<?php


Route::group([
    'namespace' => 'FeiBam\Seat\Connector\Drivers\QQ\Http\Controllers',
    'prefix' => 'seat-connector',
    'middleware' => ['web', 'auth', 'locale'],
], function(){

    Route::group([
        'prefix' => 'registration',
    ], function(){

        Route::get('/qq', [
            'as' => 'seat-connector.drivers.qq.registration',
            'uses' => 'RegistrationController@redirectToProvider'
        ]);

        Route::post('/qq', [
            'as' => 'seat-connector.drivers.qq.registration.submit',
            'uses' => 'RegistrationController@handlerSubmit',
        ]);
        
    });


    Route::group([
        'prefix' => 'settings',
        'middleware' => 'can:global.superuser',
    ], function(){ 

        Route::post('/qq', [
            'as' => 'seat-connector.drivers.qq.settings',
            'uses' => 'SettingsController@store',
        ]);

        Route::get('/qq/callback', [
            'as' => 'seat-connector.drivers.qq.settings.callback',
            'uses' => 'SettingsController@handleProviderCallback',
        ]);
    });


});