<?php

class API {
    static private function parseHeaders () {
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

    /**
     * Returns the Information about this Assignment
     * @return json
     */
    static public function version () {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Expose-Headers: "Access-Control-Allow-Origin"');

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
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers *');

        $sessionUser =  self :: parseHeaders();

        if (count($sessionUser) == 0) {
            return array(
                'status'    => 403,
                'error'   => 'Access Denied!!'
            );
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
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

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
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers *');

        $queryArgs = json_decode(file_get_contents('php://input'));
        $featureName = $queryArgs -> feature;

        $sessionUser =  self :: parseHeaders();

        if (count($sessionUser) == 0) {
            return array(
                'status'    => 403,
                'error'   => 'Access Denied!!'
            );
        } else {
            if ($sessionUser[0]['read'] !== "1") {
                return array(
                    'status'    => 403,
                    'error'   => 'Access Denied!!, you don\'t have read access.'
                );

            } else
            if ($featureName === null) {
                return array(
                    'status'    => 409,
                    'error'   => 'Invalid Feature name'
                );

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
} 