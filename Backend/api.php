<?php

class API {
    /**
     * Returns the Information about this Assignment
     * @return json
     */
    static public function version () {
        header('Access-Control-Allow-Origin: *');

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
        header('Access-Control-Allow-Origin: *');

        $loginDetails = json_decode(file_get_contents('php://input'));
        $username = $loginDetails -> username;
        $password = $loginDetails -> password;

        // TODO: Hash Password

        $user = getDatabase()->all("
          select users.idUSERS as id, users.Username, users.`GROUPS_idGROUPS` as groupId, groups.Name as 'group_name', groups.Read, groups.Write, groups.Delete, groups.Update from USERS as users
          inner join GROUPS as groups on USERS.GROUPS_idGROUPS = GROUPS.idGROUPS
          where Username = :username and password = :password", array( ':username' => $username, ':password' => $password ));

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

        return array(
            'status'    => 200,
            'message'   => 'Welcome to '.$username.'\'s Profile'
        );
    }
} 