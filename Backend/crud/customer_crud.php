<?php

class CustomerCrud {
    static public function create_customer () {
        API :: AddCORSHeaders();

        $args           = json_decode(file_get_contents('php://input'));
        $first_name     = $args -> first_name;
        $last_name      = $args -> last_name;
        $date_of_birth  = $args -> date_of_birth;
        $gender         = $args -> gender;
        $country_id     = $args -> country_id;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else {
            $customerId = getDatabase()->execute(
                'INSERT INTO `customers`(first_name, last_name, date_of_birth, gender, country_id)
                 VALUES(:first_name, :last_name, :date_of_birth, :gender, :country_id)',
                 array(
                    ':first_name' => $first_name, ':last_name' => $last_name, ':date_of_birth' => $date_of_birth,
                    ':gender' => $gender, ':country_id' => $country_id )
            );

            return array(
                'status' => 200,
                'customer_id' => $customerId
            );
        }
    }

    static public function update_customer ($id) {
        API :: AddCORSHeaders();

        $args           = json_decode(file_get_contents('php://input'));
        $first_name     = $args -> first_name;
        $last_name      = $args -> last_name;
        $date_of_birth  = $args -> date_of_birth;
        $gender         = $args -> gender;
        $country_id     = $args -> country_id;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `customers` SET `first_name`=:first_name, `last_name`=:last_name, `date_of_birth`=:date_of_birth, `gender`=:gender, `country_id`=:country_id WHERE `id` IN (:id)',
                array(
                    ':first_name' => $first_name, ':last_name' => $last_name, ':date_of_birth' => $date_of_birth,
                    ':gender' => $gender, ':country_id' => $country_id, ':id' => id )
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
     * Gets the list of available customer customers
     * @return json
     */
    static public function read_customer () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $customer = getDatabase()->all("SELECT * FROM customers;");

            return array(
                'status' => 200,
                'customer_customer' => $customer
            );
        }
    }

    static public function delete_customer ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");


        if ($error !== null) {
            return $error;
        } else {
            getDatabase()->execute("DELETE FROM `customers` WHERE `id` IN (:id)", array(':id' => $id));

            header("HTTP/1.0 204 No Content");
            return array(
                'status' => 204,
                'message' => 'Successfully deleted.'
            );
        }
    }
} 