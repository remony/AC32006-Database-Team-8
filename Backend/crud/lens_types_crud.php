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
                'status' => 201,
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

            header("HTTP/1.0 202 Accepted");
            return array(
                'status' => 202,
                'deleted' => $affectedRows
            );
        }
    }

    static public function add_lens_to_type ($type, $lens) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else {
            try {
                $exist = getDatabase() -> one("
                    SELECT `type`.`id` as 'type', `lens`.`id` as 'lens' FROM `type`
                    INNER JOIN `lens` ON `lens`.`id` = :lens_id
                    WHERE `type`.`id` = :type_id;
                ", array(
                        ':type_id' => $lens, ':lens_id' => $type )
                );

                if ($exist) {
                    getDatabase()->execute(
                        'INSERT INTO `type_has_lens`(type_id, lens_id)
                        VALUES(:type_id, :lens_id)',
                        array(
                            ':type_id' => $type, ':lens_id' => $lens )
                    );

                    header("HTTP/1.0 205 Successfully updated");
                    return array(
                        'status' => 205,
                        'message' => 'Successfully updated. (update local content)'
                    );
                } else {
                    header("HTTP/1.0 409");
                    return array(
                        'status' => 409,
                        'message' => 'That Type or Lens doesn\'t exist.'
                    );
                }

            } catch (EpiDatabaseQueryException $error) {
                header("HTTP/1.0 409");
                return array(
                    'status' => 409,
                    'message' => 'That connection already exists.'
                );
            }
        }
    }

    static public function remove_lens_from_type ($type, $lens) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            try {
                getDatabase()->execute(
                    "DELETE FROM `type_has_lens` WHERE `type_id` IN (:type_id) AND `lens_id` IN (:lens_id)",
                    array(':type_id' => $type, ':lens_id' => $lens)
                );

                header("HTTP/1.0 204 No Content");
                return array(
                    'status' => 204,
                    'message' => 'Successfully deleted.'
                );
            } catch (EpiDatabaseQueryException $error) {
                header("HTTP/1.0 409");
                return array(
                    'status' => 409,
                    'message' => 'That Type or Lens doesn\'t exist.'
                );
            }
        }
    }

    static public function lens_from_type ($type) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $lenses = getDatabase()->all(
                "SELECT * FROM `type_has_lens` where `type_id` IN (:type_id);",
                array( ':type_id' => $type )
            );

            return array(
                'status' => 200,
                'lenses' => $lenses
            );
        }
    }
} 