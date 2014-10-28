<?php

class API {
    /**
     * Returns the Information about this Assignment
     * @return json
     */
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

    /**
     * Generates an access_token for the User, (if the login details are right)
     * @body json -> {
     *      "username" : the username,
     *      "password" : the password
     * }
     * @return json
     */
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

    /**
     * Returns the User's profile data
     * @param $username
     * @return json
     */
    static public function profile ($username) {
        return array(
            'status'    => 200,
            'message'   => 'Welcome to '.$username.'\'s Profile'
        );
    }
} 