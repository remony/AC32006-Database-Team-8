<?php

class SalesCrud {
    static public function create_sale () {
        API :: AddCORSHeaders();

        $args       = json_decode(file_get_contents('php://input'));
        $camera     = $args -> camera_id;
        $store      = $args -> store_id;
        $customer   = $args -> customer_id;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else {
            $saleId = getDatabase()->execute( '
              INSERT INTO `sales`(date_purchased, camera_id, store_id, customer_id)
              VALUES(now(), :camera_id, :store_id, :customer_id)',
              array(':camera_id' => $camera, ':store_id' => $store, 'customer_id' => $customer ) );

            return array(
                'status' => 201,
                'sale_id' => $saleId
            );
        }
    }

    static public function update_sale ($id) {
        API :: AddCORSHeaders();

        $args = json_decode(file_get_contents('php://input'));
        $camera     = $args -> camera_id;
        $store      = $args -> store_id;
        $customer   = $args -> customer_id;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `sales` SET camera_id=:camera_id, store_id=:store_id, customer_id=:customer_id WHERE `id` IN (:id)',

                array( ':camera_id' => $camera, ':store_id' => $store, 'customer_id' => $customer, ':id' => $id ) );

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
     * Gets the list of available sale types
     * @return json
     */
    static public function read_sale () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $sales = getDatabase()->all("SELECT * FROM sales;");

            return array(
                'status' => 200,
                'sales' => $sales
            );
        }
    }

    /**
     * Gets the list of available sale for user
     * @return json
     */
    static public function read_sales_user ($customer) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $sales = getDatabase()->all("select * from `detailed_sales` where customer_id = :customer_id", array( ':customer_id' => $customer ));
//                SELECT sales.id, date_purchased, camera_id, store_id, customer_id, cameras.brand 'camera_brand', cameras.model_name 'camera_model', stores.name 'store_name', customers.first_name 'customer_first_name', customers.last_name 'customer_last_name' FROM `sales`
//                LEFT OUTER JOIN `cameras` ON `cameras`.`id` = `sales`.`camera_id`
//                LEFT OUTER JOIN `stores` ON `stores`.`id` = `sales`.`store_id`
//                LEFT OUTER JOIN `customers` ON `customers`.`id` = `sales`.`customer_id`
//                WHERE sales.customer_id IN (:customer_id)
//            ", array( ':customer_id' => $customer ));

            return array(
                'status' => 200,
                'sales' => $sales
            );
        }
    }


    static public function numberOfSales ($filter) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $query = "";
            if ($filter === "earnings") {
                $query = "select `country` 'label', `TotalAmount` 'value' from `sales_statistics` ORDER BY TotalAmount DESC;";

            } else if ($filter === "number") {
                $query = "select `country` 'label', `NumberOfSales` 'value' from `sales_statistics` ORDER BY NumberOfSales DESC;";
            }

            $sales = getDatabase()->all($query);

            header("HTTP/1.0 200 Ok.");
            return array(
                'status' => 200,
                'sales' => $sales
            );
        }
    }

    static public function delete_sale ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute("DELETE FROM `sales` WHERE `id` IN (:id)", array(':id' => $id));

            header("HTTP/1.0 202 Accepted");
            return array(
                'status' => 202,
                'deleted' => $affectedRows
            );
        }
    }
} 