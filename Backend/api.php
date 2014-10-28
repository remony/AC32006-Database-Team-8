<?php

class API {
    static public function version () {
        return array(
            'module'    => 'AC32006',
            'team'      => 10,
            'version'   => 0.1,
            'members'   => [
                'Jose Salvatierra',
                'Stuart Douglas',
                'Jeremy Rasoldier',
                'Yago Carballo'
            ]
        );
    }

    static public function login () {
        $loginDetails = json_decode(file_get_contents('php://input'));
        $username = $loginDetails -> username;
        $password = $loginDetails -> password;

        // TODO: Check Password

        return array(
            'status'    => 200,
            'message'   => 'You\'ve logged in successfully'
        );
    }

    static public function profile ($username) {
        return array(
            'status'    => 200,
            'message'   => 'Welcome to '.$username.'\'s Profile'
        );
    }
} 