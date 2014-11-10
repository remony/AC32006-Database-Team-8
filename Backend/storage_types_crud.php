<?php

class StorageTypesCrud {
    static public function create_storage () {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid storage name"
            );
        } else {
            $storageId = getDatabase()->execute('INSERT INTO `storage`(name) VALUES(:name)', array( ':name' => $name ) );

            return array(
                'status' => 200,
                'storage_id' => $storageId
            );
        }
    }

    static public function update_storage ($id) {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $name = $args -> name;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else if ($name === null) {
            return array(
                'status' => 409,
                'error' => "Invalid storage name"
            );
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `storage` SET `name`=:name WHERE `id` IN (:id)', array( ':name' => $name, ':id' => intval($id)));

            return array(
                'status' => 200,
                'updated' => $affectedRows
            );
        }
    }

    /**
     * Gets the list of available storage types
     * @return json
     */
    static public function read_storage () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $storage_types = getDatabase()->all("SELECT * FROM storage;");

            return array(
                'status' => 200,
                'storage_types' => $storage_types
            );
        }
    }

    static public function delete_storage ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute("DELETE FROM `storage` WHERE `id` IN (:id)", array(':id' => $id));

            return array(
                'status' => 200,
                'deleted' => $affectedRows
            );
        }
    }
} 