<?php

namespace App;
use App\Helpers\Helper;

class UserQuery {

    function selectUserAdminData($query, $input) {
        $user = new \StdClass();

        $user->id = $input->id;
        $user->name = "hello";
        $user->per = "10";

        return $user;
    }
}