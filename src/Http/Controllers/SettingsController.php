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


class SettingsController extends Controller {

    public function store(Request $request){
        $validatedData = $request->validate([
            'allow_modification_bind_infomation' => 'boolean'
        ]);

        setting(['seat-connector.drivers.QQ', null], true);

        $settings = (object) [
            'allow_modification_bind_infomation' => $request->input('allow_modification_bind_infomation', 0),
        ];

        setting(['seat-connector.drivers.QQ', $settings], true);

        return redirect()->route('seat-connector.settings')
                     ->with('success', 'Discord settings have been successfully updated.');
    }

}