<?php

class LensTypesCrud {
    static public function create_lens () {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid lens name"
            );
        } else {
            $lensId = getDatabase()->execute( 'INSERT INTO `lens`(name) VALUES(:name)', array( ':name' => $name ) );

            return array(
                'status' => 200,
                'lens_id' => $lensId
            );
        }
    }

    static public function update_lens ($id) {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid lens name"
            );
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `lens` SET `name`=:name WHERE `id` IN (:id)', array( ':name' => $name, ':id' => intval($id)));

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
     * Gets the list of available lens types
     * @return json
     */
    static public function read_lens () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $lens_type = getDatabase()->all("SELECT * FROM lens;");

            return array(
                'status' => 200,
                'lens_type' => $lens_type
            );
        }
    }

    static public function delete_lens ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute("DELETE FROM `lens` WHERE `id` IN (:id)", array(':id' => $id));

            return array(
                'status' => 200,
                'deleted' => $affectedRows
            );
        }
    }
} 