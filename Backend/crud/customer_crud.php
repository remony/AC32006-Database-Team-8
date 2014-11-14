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
                'status' => 201,
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
                    ':gender' => $gender, ':country_id' => $country_id, ':id' => $id )
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
            $affectedRows = getDatabase()->execute("DELETE FROM `customers` WHERE `id` IN (:id)", array(':id' => $id));

            header("HTTP/1.0 202 Accepted");
            return array(
                'status' => 202,
                'deleted' => $affectedRows
            );
        }
    }

    static public function add_hobby_to_customer ($customer, $hobby) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else {
            try {
                $exist = getDatabase() -> one("
                    SELECT `customers`.`id` as 'user', `hobby`.`id` as 'hobby' FROM `customers`
                    INNER JOIN `hobby` ON `hobby`.`id` = :hobby_id
                    WHERE `customers`.`id` = :customer_id;
                ", array(
                        ':customer_id' => $customer, ':hobby_id' => $hobby )
                );

                if ($exist) {
                    getDatabase()->execute(
                        'INSERT INTO `customer_has_hobby`(customer_id, hobby_id)
                        VALUES(:customer_id, :hobby_id)',
                        array(
                            ':customer_id' => $customer, ':hobby_id' => $hobby )
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
                        'message' => 'That Hobby or Customer doesn\'t exist.'
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

    static public function remove_hobby_from_customer ($customer, $hobby) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            try {
                getDatabase()->execute(
                    "DELETE FROM `customer_has_hobby` WHERE `customer_id` IN (:customer_id) AND `hobby_id` IN (:hobby_id)",
                    array(':customer_id' => $customer, ':hobby_id' => $hobby)
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
                    'message' => 'That Hobby or Customer doesn\'t exist.'
                );
            }
        }
    }

    static public function hobby_from_customer ($customer) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $hobbies = getDatabase()->all(
                "SELECT * FROM `customer_has_hobby` where `customer_id` IN (:customer_id);",
                array( ':customer_id' => $customer )
            );

            return array(
                'status' => 200,
                'hobbies' => $hobbies
            );
        }
    }

    static public function add_profession_to_customer ($customer, $profession) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else {
            try {
                $exist = getDatabase() -> one("
                    SELECT `customers`.`id` as 'user', `profession`.`id` as 'profession' FROM `customers`
                    INNER JOIN `profession` ON `profession`.`id` = :profession_id
                    WHERE `customers`.`id` = :customer_id;
                ", array(
                        ':customer_id' => $customer, ':profession_id' => $profession )
                );

                if ($exist) {
                    getDatabase()->execute(
                        'INSERT INTO `customer_has_profession`(customer_id, profession_id)
                        VALUES(:customer_id, :profession_id)',
                        array(
                            ':customer_id' => $customer, ':profession_id' => $profession )
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
                        'message' => 'That Profession or Customer doesn\'t exist.'
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

    static public function remove_profession_from_customer ($customer, $profession) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            try {
                getDatabase()->execute(
                    "DELETE FROM `customer_has_profession` WHERE `customer_id` IN (:customer_id) AND `profession_id` IN (:profession_id)",
                    array(':customer_id' => $customer, ':profession_id' => $profession)
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
                    'message' => 'That Profession or Customer doesn\'t exist.'
                );
            }
        }
    }

    static public function profession_from_customer ($customer) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $professions = getDatabase()->all(
                "SELECT * FROM `customer_has_profession` where `customer_id` IN (:customer_id);",
                array( ':customer_id' => $customer )
            );

            return array(
                'status' => 200,
                'hobbies' => $professions
            );
        }
    }
} 