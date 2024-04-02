<?php

namespace App\Models;
use Carbon\Carbon;



class UserSession {
    public $id;
    public $isLogin;
    public $username;
    public $role;
    public $station_id;
    public $region_id;
    public $today;

    public function __construct($id,$isLogin, $username, $role,$station_id,$region_id) {
        $this->id = $id;
        $this->isLogin = $isLogin;
        $this->username = $username;
        $this->role = $role;
        $this->station_id = $station_id;
        $currentDate = Carbon::now();  
        $this->region_id = $region_id;
        $this->today = $currentDate->toDateString() ;
    }
}
