<?PHP
    // Sosumi - a PHP client for Apple's Find My iPhone web service
    //
    // June 20, 2010
    // Tyler Hall <tylerhall@gmail.com>
    // http://github.com/tylerhall/sosumi/tree/master
    //
    // Usage:
    // $ssm = new Sosumi('username', 'password');
    // $location_info = $ssm->locate(<device number>);
    // $ssm->sendMessage(<device number>, 'Your Subject', 'Your Message');
    //

    class Sosumi
    {
        public $devices;
        public $debug;
        private $username;
        private $password;
        private $curl_resource;

        public function __construct($mobile_me_username, $mobile_me_password, $debug = false)
        {
            $this->devices  = array();
            $this->debug    = $debug;
            $this->username = $mobile_me_username;
            $this->password = $mobile_me_password;
            $this->updateDevices();
        }

        public function locate($device_num = 0, $max_wait = 300)
        {
            $start = time();

            // Loop until the device has been located...
            while($this->devices[$device_num]->locationFinished != 1)
            {
                $this->iflog('Waiting for location...');
                if((time() - $start) > $max_wait)
                {
                    throw new Exception("Unable to find location within '$max_wait' seconds\n");
                }

                sleep(5);
                $this->updateDevices();
            }

            $loc = array(
                        "latitude"  => $this->devices[$device_num]->latitude,
                        "longitude" => $this->devices[$device_num]->longitude,
                        "accuracy"  => $this->devices[$device_num]->horizontalAccuracy,
                        "timestamp" => $this->devices[$device_num]->locationTimestamp,
                        );

            return $loc;
        }

        public function sendMessage($msg, $alarm = false, $device_num = 0, $subject = 'Important Message')
        {
            $post = sprintf('{"clientContext":{"appName":"FindMyiPhone","appVersion":"1.0","buildVersion":"57","deviceUDID":"0000000000000000000000000000000000000000","inactiveTime":5911,"osVersion":"3.2","productType":"iPad1,1","selectedDevice":"%s","shouldLocate":false},"device":"%s","serverContext":{"callbackIntervalInMS":3000,"clientId":"0000000000000000000000000000000000000000","deviceLoadStatus":"203","hasDevices":true,"lastSessionExtensionTime":null,"maxDeviceLoadTime":60000,"maxLocatingTime":90000,"preferredLanguage":"en","prefsUpdateTime":1276872996660,"sessionLifespan":900000,"timezone":{"currentOffset":-25200000,"previousOffset":-28800000,"previousTransition":1268560799999,"tzCurrentName":"Pacific Daylight Time","tzName":"America/Los_Angeles"},"validRegion":true},"sound":%s,"subject":"%s","text":"%s"}',
                                $this->devices[$device_num]->id, $this->devices[$device_num]->id,
                                $alarm ? 'true' : 'false', $subject, $msg);

            $this->iflog('Sending message...');
            $this->curlPost("https://fmipmobile.me.com/fmipservice/device/$mobile_me_username/sendMessage", $post);
            $this->iflog('Message sent');
        }

        public function remoteLock($passcode, $device_num = 0)
        {
            $post = sprintf('{"clientContext":{"appName":"FindMyiPhone","appVersion":"1.0","buildVersion":"57","deviceUDID":"0000000000000000000000000000000000000000","inactiveTime":5911,"osVersion":"3.2","productType":"iPad1,1","selectedDevice":"%s","shouldLocate":false},"device":"%s","oldPasscode":"","passcode":"%s","serverContext":{"callbackIntervalInMS":3000,"clientId":"0000000000000000000000000000000000000000","deviceLoadStatus":"203","hasDevices":true,"lastSessionExtensionTime":null,"maxDeviceLoadTime":60000,"maxLocatingTime":90000,"preferredLanguage":"en","prefsUpdateTime":1276872996660,"sessionLifespan":900000,"timezone":{"currentOffset":-25200000,"previousOffset":-28800000,"previousTransition":1268560799999,"tzCurrentName":"Pacific Daylight Time","tzName":"America/Los_Angeles"},"validRegion":true}}',
                                $this->devices[$device_num]->id, $this->devices[$device_num]->id, $passcode);

            $this->iflog('Sending remote lock...');
            $this->curlPost("https://fmipmobile.me.com/fmipservice/device/$mobile_me_username/remoteLock", $post);
            $this->iflog('Remote lock sent');
        }

        // This hasn't been tested (for obvious reasons). Please let me know if it does/doesn't work...
        public function remoteWipe($device_num = 0)
        {
            $post = sprintf('{"clientContext":{"appName":"FindMyiPhone","appVersion":"1.0","buildVersion":"57","deviceUDID":"0000000000000000000000000000000000000000","inactiveTime":5911,"osVersion":"3.2","productType":"iPad1,1","selectedDevice":"%s","shouldLocate":false},"device":"%s","oldPasscode":"","passcode":"%s","serverContext":{"callbackIntervalInMS":3000,"clientId":"0000000000000000000000000000000000000000","deviceLoadStatus":"203","hasDevices":true,"lastSessionExtensionTime":null,"maxDeviceLoadTime":60000,"maxLocatingTime":90000,"preferredLanguage":"en","prefsUpdateTime":1276872996660,"sessionLifespan":900000,"timezone":{"currentOffset":-25200000,"previousOffset":-28800000,"previousTransition":1268560799999,"tzCurrentName":"Pacific Daylight Time","tzName":"America/Los_Angeles"},"validRegion":true}}',
                                $this->devices[$device_num]->id, $this->devices[$device_num]->id, $passcode);

            $this->iflog('Sending remote wipe...');
            $this->curlPost("https://fmipmobile.me.com/fmipservice/device/$mobile_me_username/remoteWipe", $post);
            $this->iflog('Remote wipe sent');
        }

        private function updateDevices()
        {
            do
            {
                $post     = '{"clientContext":{"appName":"FindMyiPhone","appVersion":"1.1","buildVersion":"99","deviceUDID":"0cf3dc491ff812adb0b202baed4f94873b210853","inactiveTime":2147483647,"osVersion":"4.2.1","personID":0,"productType":"iPhone3,1"}}';
                $this->iflog('Updating devices...');
                $json_str = $this->curlPost("https://fmipmobile.me.com/fmipservice/device/$this->username/initClient", $post);

                if(curl_getinfo($this->curl_resource, CURLINFO_HTTP_CODE) == 330)
                {
                    $this->iflog('Received 330 from MobileMe, trying again');
                    sleep(5);
                    continue;
                }
                elseif(curl_getinfo($this->curl_resource, CURLINFO_HTTP_CODE) != 200)
                {
                    throw new Exception("Error from web service: [" . curl_getinfo($this->curl_resource, CURLINFO_HTTP_CODE) . "] '$json_str'");
                }
            } while (curl_getinfo($this->curl_resource, CURLINFO_HTTP_CODE) == 330);

            $this->iflog('Device updates received');
            $json     = json_decode($json_str);

            if(is_null($json))
                throw new Exception("Error parsing json string");

            if(isset($json->error))
                throw new Exception("Error from web service: '$json->error'");

            $this->devices = array();
            $this->iflog('Parsing ' . count($json->content) . ' devices...');
            foreach($json->content as $json_device)
            {
                $device = new SosumiDevice();
                if(isset($json_device->location) && is_object($json_device->location))
                {
                    $device->locationTimestamp  = date('Y-m-d H:i:s', $json_device->location->timeStamp / 1000);
                    $device->locationType       = $json_device->location->positionType;
                    $device->horizontalAccuracy = $json_device->location->horizontalAccuracy;
                    $device->locationFinished   = $json_device->location->locationFinished;
                    $device->longitude          = $json_device->location->longitude;
                    $device->latitude           = $json_device->location->latitude;
                }
                $device->isLocating     = $json_device->isLocating;
                $device->deviceModel    = $json_device->deviceModel;
                $device->deviceStatus   = $json_device->deviceStatus;
                $device->id             = $json_device->id;
                $device->name           = $json_device->name;
                $device->deviceClass    = $json_device->deviceClass;
                $device->chargingStatus = $json_device->a;
                $device->batteryLevel   = $json_device->b;
                $this->devices[]        = $device;
            }
        }

        private function curlPost($url, $post_vars = '', $headers = array())
        {
            $headers[] = 'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password);
            $headers[] = 'X-Apple-Find-Api-Ver: 2.0';
            $headers[] = 'X-Apple-Authscheme: UserIdGuest';
            $headers[] = 'X-Apple-Realm-Support: 1.0';
            $headers[] = 'Content-Type: application/json; charset=utf-8';
            $headers[] = 'X-Client-Name: Steve?s iPhone';
            $headers[] = 'X-Client-Uuid: 0cf3dc491ff812adb0b202baed4f94873b210853';
            $headers[] = 'Accept-Language: en-us';
            $headers[] = 'Pragma: no-cache';
            $headers[] = 'Connection: keep-alive';

            $this->curl_resource = curl_init($url);
            curl_setopt($this->curl_resource, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($this->curl_resource, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($this->curl_resource, CURLOPT_AUTOREFERER, true);
            curl_setopt($this->curl_resource, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->curl_resource, CURLOPT_USERAGENT, 'Find iPhone/1.1 MeKit (iPhone: iPhone OS/4.2.1)');
            curl_setopt($this->curl_resource, CURLOPT_POST, true);
            curl_setopt($this->curl_resource, CURLOPT_POSTFIELDS, $post_vars);
            if(!is_null($headers)) curl_setopt($this->curl_resource, CURLOPT_HTTPHEADER, $headers);

            // curl_setopt($this->curl_resource, CURLOPT_VERBOSE, true);

            return curl_exec($this->curl_resource);
        }

        private function iflog($str)
        {
            if($this->debug === true)
                echo $str . "\n";
        }
    }

    class SosumiDevice
    {
        public $isLocating;
        public $locationTimestamp;
        public $locationType;
        public $horizontalAccuracy;
        public $locationFinished;
        public $longitude;
        public $latitude;
        public $deviceModel;
        public $deviceStatus;
        public $id;
        public $name;
        public $deviceClass;

        // These values only recently appeared in Apple's JSON response.
        // Their final names will probably change to something other than
        // 'a' and 'b'.
        public $chargingStatus; // location->a
        public $batteryLevel; // location->b
    }
