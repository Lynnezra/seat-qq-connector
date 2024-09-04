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
        $settings = setting('seat-connector.drivers.QQ', true);
        $allow_modification = $settings->allow_modification_bind_infomation;
        $seat_user = auth()->user();
        $driver_user = User::where('connector_type', 'qq')
            ->where('user_id', $seat_user->id)
            ->first();
    
        if (!is_null($driver_user)) {
            if (!$allow_modification) {
                return redirect()->back()
                    ->with('warning', trans("seat-qq-connector::seat.not_allow_modification_bind_infomation_waring"));
            }
            // 调用更新绑定信息的方法
            return $this->handlerUpdateBindInfomation($request);
        }
    
        // 调用绑定 QQ 账户的方法
        return $this->handlerBindQQAccount($request);
    }

    public function handlerBindQQAccount(Request $request) {
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
                'max:32',
            ],
        ]);
    
        $driver_user = new User();
        $seat_user = auth()->user();
        $qq_number = $validatedData['qq_number'];
        $qq_name = $validatedData['qq_name'];
        $seat_user_id = $seat_user->id;
        $unique_id = md5("$seat_user_id$qq_name$qq_number");
    
        $driver_user->connector_type = 'qq';
        $driver_user->user_id = $seat_user_id;
        $driver_user->connector_id = $qq_number;
        $driver_user->unique_id = $unique_id;
        $driver_user->connector_name = $qq_name;
    
        $driver_user->save();
    
        return redirect(route("seat-connector.identities"));
    }

    public function handlerUpdateBindInfomation(Request $request) {
        $validatedData = $request->validate([
            'qq_number' => [
                'required_without:qq_name',
                'integer',
                'digits_between:5,18',
            ],
            'qq_name' => [
                'required_without:qq_number',
                'string',
                'min:1',
                'max:32',
            ],
        ]);
    
        $seat_user = auth()->user();  // 先获取 $seat_user
        $driver_user = User::where('connector_type', 'qq')
            ->where('user_id', $seat_user->id)
            ->first();
    
        $qq_number = $validatedData['qq_number'] ?? $driver_user->connector_id;
        $qq_name = $validatedData['qq_name'] ?? $driver_user->connector_name;
    
        $driver_user->connector_id = $qq_number;
        $driver_user->connector_name = $qq_name;
    
        $driver_user->update();
    
        return redirect(route("seat-connector.identities"));
    }
}