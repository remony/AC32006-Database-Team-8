<?php

class ProfessionCrud {
    static public function create_profession () {
        API :: AddCORSHeaders();

        $args           = json_decode(file_get_contents('php://input'));
        $title          = $args -> title;
        $salary         = $args -> salary;
        $years          = $args -> years;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else {
            $professionId = getDatabase()->execute(
                'INSERT INTO `profession`(title, salary, years)
                 VALUES(:title, :salary, :years)',
                array(':title' => $title, ':salary' => $salary, ':years' => $years)
            );

            return array(
                'status' => 200,
                'profession_id' => $professionId
            );
        }
    }

    static public function update_profession ($id) {
        API :: AddCORSHeaders();

        $args           = json_decode(file_get_contents('php://input'));
        $title          = $args -> title;
        $salary         = $args -> salary;
        $years          = $args -> years;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `profession` SET `title`=:title, `salary`=:salary, `years`=:years WHERE `id` IN (:id)',
                array(':title' => $title, ':salary' => $salary, ':years' => $years, ':id' => $id)
            );

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
     * Gets the list of available professions
     * @return json
     */
    static public function read_profession () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $profession = getDatabase()->all("SELECT * FROM profession;");

            return array(
                'status' => 200,
                'profession' => $profession
            );
        }
    }

    static public function delete_profession ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");


        if ($error !== null) {
            return $error;
        } else {
            getDatabase()->execute("DELETE FROM `profession` WHERE `id` IN (:id)", array(':id' => $id));

            header("HTTP/1.0 204 No Content");
            return array(
                'status' => 204,
                'message' => 'Successfully deleted.'
            );
        }
    }
} 