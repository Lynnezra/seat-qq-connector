<?php

namespace FeiBam\Seat\Connector\Drivers\QQ\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Seat\Web\Http\Controllers\Controller;
use SocialiteProviders\Manager\Config;
use Warlof\Seat\Connector\Drivers\Discord\Driver\DiscordClient;
use Warlof\Seat\Connector\Drivers\Discord\Helpers\Helper;
use Warlof\Seat\Connector\Drivers\IClient;
use Warlof\Seat\Connector\Events\EventLogger;
use Warlof\Seat\Connector\Exceptions\DriverSettingsException;
use Warlof\Seat\Connector\Models\User;
use FeiBam\Seat\Connector\Drivers\QQ\Driver\QQClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;

class RegistrationController extends Controller{

    public function redirectToProvider() {
        $seat_user = auth()->user();
        $allow_modification = False;

        $driver_user = User::where('connector_type', 'qq')
        ->where('user_id', $seat_user->id)
        ->first();

        if(is_null($driver_user)){
            $driver_user = new User();
        }

        $settings = setting('seat-connector.drivers.QQ', true);
        
        if (is_null($settings) || ! is_object($settings))
            throw new DriverSettingsException('The Driver has not been configured yet.');

        if (! property_exists($settings, 'allow_modification_bind_infomation'))
            throw new DriverSettingsException('The Driver has not been configured yet.');

        $allow_modification = $settings -> allow_modification_bind_infomation;

        return view('seat-qq-connector::registration.qq',[ 
            'driver_user' => $driver_user,
            'seat_user' => $seat_user ,
            'allow_modification' => $allow_modification 
        ]);
    }

    public function handlerSubmit(Request $request) {
        $validatedData = $request->validate([
            'qq_number' => [
                'required',
                'integer',
                'digits_between:5,18',
            ],
            'qq_name' => [
                'required',
                'string',
                'min:1',
                'max:32'
            ]
        ]);

        $qq_number = $validatedData['qq_number'];
        $qq_name = $validatedData['qq_name'];
        $seat_user_id = auth() -> user() -> id;
        $unique_id = md5("$seat_user_id$qq_name$qq_number");

        $driver_user = User::updateOrCreate([
            'connector_type' => 'qq',
            'user_id'        => auth()->user()->id,
        ], [
            'connector_id'   => "$qq_number",
            'unique_id'      => "$unique_id",
            'connector_name' => "$qq_name",
        ]);
        return redirect(route("seat-connector.identities"));
    }
}