<?php

class API {
    static public function parseHeaders () {
        $headers = apache_request_headers();
        if (array_key_exists('Authorization', $headers)) {
            $access_token = $headers["Authorization"];
            if ($access_token) {
                $user = getDatabase()->all("CALL sessionUser(:access_token);", array( ':access_token' => $access_token ));
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }

    }

    static public function CheckAuth ($permission) {
        $sessionUser =  self :: parseHeaders();

        if (count($sessionUser) == 0) {
            return array(
                'status'    => 403,
                'error'   => 'Access Denied!!'
            );
        } else {
            if ($sessionUser[0][$permission] !== "1") {
                return array(
                    'status' => 403,
                    'error' => 'Access Denied!!, you don\'t have '.$permission.' access.'
                );
            } else {
                return null;
            }
        }
    }

    static public function AddCORSHeaders () {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Expose-Headers: "Access-Control-Allow-Origin"');
    }

    /**
     * Returns the Information about this Assignment
     * @return json
     */
    static public function version () {
        self :: AddCORSHeaders();

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
        self :: AddCORSHeaders();

        $loginDetails = json_decode(file_get_contents('php://input'));
        $username = $loginDetails -> username;
        $password = $loginDetails -> password;

        $user = getDatabase()->all("CALL signIn(:username, :password);", array( ':username' => $username, ':password' => sha1($password) ));

        if (count($user) == 1) {
            return array(
                'status'    => 200,
                'message'   => 'You\'ve logged in successfully',
                'user'      => $user
            );
        } else {
            return array(
                'status'    => 403,
                'error'   => 'Access Denied!!'
            );
        }
    }

    /**
     * Returns the User's profile data
     * @param $username
     * @return json
     */
    static public function profile ($username) {
        self :: AddCORSHeaders();

        $sessionUser =  self :: parseHeaders();

        $error = self :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            return $sessionUser;
        }
    }

    /**
     * Registers the User in the Database
     * @body json -> {
     *      "username" : the username,
     *      "password" : the password
     * }
     * @return json
     */
    static public function register () {
        self :: AddCORSHeaders();

        $loginDetails = json_decode(file_get_contents('php://input'));
        $username = $loginDetails -> username;
        $password = $loginDetails -> password;

        $user = getDatabase()->all("CALL registerUser(:username, :password);", array( ':username' => $username, ':password' => sha1($password) ));

        if (count($user) === 1) {
            if (array_key_exists("error", $user[0])) {
                return array(
                    'status' => 409,
                    'error' => $user[0]["error"]
                );
            } else {
                return array(
                    'status' => 200,
                    'message' => 'You\'ve registered in successfully',
                    'user' => $user
                );
            }
        } else {
            return array(
                'status'    => 403,
                'error'   => 'Access Denied!!'
            );
        }
    }

    /**
     * Gets the list of available countries
     * @return json
     */
    static public function countries () {
        self :: AddCORSHeaders();

        $countries = getDatabase()->all("SELECT * FROM countries;");

        return array(
            'status' => 200,
            'countries' => $countries
        );
    }

    /**
     * Refurns cameras filtered by the features
     * @param $featureName
     * @return json
     */
    static public function queryFeatures () {
        self :: AddCORSHeaders();

        $queryArgs = json_decode(file_get_contents('php://input'));
        $featureName = $queryArgs -> feature;

        $error = self :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $cameras = getDatabase()->all("
                    SELECT `cameras`.`id`, `cameras`.`brand`, `cameras`.`model_name`, `storage`.`name` as 'storage', `type`.`name` as 'type', `cameras`.`battery_type`, `cameras`.`megapixels`, `cameras`.`resolution` FROM `cameras`
                    INNER JOIN `type` ON `cameras`.`type_id` = `type`.`id`
                    INNER JOIN `storage` ON `cameras`.`storage_id` = `storage`.`id`
                    WHERE `cameras`.`battery_type` LIKE :feature OR `cameras`.`megapixels` LIKE :feature OR `cameras`.`resolution` LIKE :feature OR `type`.`name` LIKE '%:feature%' OR `storage`.`name` LIKE '%:feature%';
                ", array( ':feature' => '%'.$featureName.'%'));

            return array(
                'status'    => 200,
                'cameras'   => $cameras
            );
        }
    }
} 