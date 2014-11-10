<?php

class CameraTypesCrud {
    static public function create_type () {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid camera type name"
            );
        } else {
            $typeId = getDatabase()->execute( 'INSERT INTO `type`(name) VALUES(:name)', array( ':name' => $name ) );

            return array(
                'status' => 200,
                'type_id' => $typeId
            );
        }
    }

    static public function update_type ($id) {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid type name"
            );
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `type` SET `name`=:name WHERE `id` IN (:id)', array( ':name' => $name, ':id' => intval($id)));

            return array(
                'status' => 200,
                'updated' => $affectedRows
            );
        }
    }

    /**
     * Gets the list of available type types
     * @return json
     */
    static public function read_type () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $camera_type = getDatabase()->all("SELECT * FROM type;");

            return array(
                'status' => 200,
                'camera_type' => $camera_type
            );
        }
    }

    static public function delete_type ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute("DELETE FROM `type` WHERE `id` IN (:id)", array(':id' => $id));

            return array(
                'status' => 200,
                'deleted' => $affectedRows
            );
        }
    }
} 