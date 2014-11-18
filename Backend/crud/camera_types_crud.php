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
                'status' => 201,
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

            if ($affectedRows === 1) {
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


    static public function popular_type_camera_in_country ($country) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");


        if ($error !== null) {
            return $error;
        } else {
            $cameras = getDatabase() -> all("
                select TypeOfCamera as 'type', NumberOfSales as 'sales' from `camera_types_top` where country = :country
                union
                select name as 'type', 0 as 'sales' from `type` where name not in (select TypeOfCamera as 'type_name' from `camera_types_top` where country = :country);
            ", array(':country' => $country));

            header("HTTP/1.0 200 OK");
            return array(
                'status' => 200,
                'data' => $cameras
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

            header("HTTP/1.0 202 Accepted");
            return array(
                'status' => 202,
                'deleted' => $affectedRows
            );
        }
    }
} 