<?php

class HobbyTypesCrud {
    static public function create_hobby () {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid hobby name"
            );
        } else {
            $hobbyId = getDatabase()->execute( 'INSERT INTO `hobby`(name) VALUES(:name)', array( ':name' => $name ) );

            return array(
                'status' => 200,
                'hobby_id' => $hobbyId
            );
        }
    }

    static public function update_hobby ($id) {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid hobby name"
            );
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `hobby` SET `name`=:name WHERE `id` IN (:id)', array( ':name' => $name, ':id' => intval($id)));

            if ($affectedRows === 0) {
                header("HTTP/1.0 205 Successfully updated");
                return array(
                    'status' => 205,
                    'message' => 'Successfully updated. (update local content)'
                );
            } else {
                header("HTTP/1.0 204 Successfully updated");
                return array(
                    'status' => 204,
                    'message' => 'Successfully updated.'
                );
            }
        }
    }

    /**
     * Gets the list of available hobby types
     * @return json
     */
    static public function read_hobby () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $hobby_type = getDatabase()->all("SELECT * FROM hobby;");

            return array(
                'status' => 200,
                'hobby_type' => $hobby_type
            );
        }
    }

    static public function delete_hobby ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute("DELETE FROM `hobby` WHERE `id` IN (:id)", array(':id' => $id));

            return array(
                'status' => 200,
                'deleted' => $affectedRows
            );
        }
    }
} 