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

            return array(
                'status' => 200,
                'sales' => $sales
            );
        }
    }


    static public function numberOfSales ($filter)
    {
        API:: AddCORSHeaders();

        $error = API:: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            if ($filter !== "date") {
                $query = "";
                if ($filter === "earnings") {
                    $query = "select `country` 'label', `TotalAmount` 'value' from `sales_statistics_countries` ORDER BY TotalAmount DESC;";

                } else if ($filter === "number") {
                    $query = "select `country` 'label', `NumberOfSales` 'value' from `sales_statistics_countries` ORDER BY NumberOfSales DESC;";
                }

                $sales = getDatabase()->all($query);

                for ($i=0;$i<count($sales);$i++) {
                    $sales[$i]['value'] = intval($sales[$i]['value']);
                }

                header("HTTP/1.0 200 Ok.");
                return array(
                    'status' => 200,
                    'sales' => $sales
                );

            } else {
                $query = getDatabase()->all("select DATE_FORMAT(str_to_date(`date`, '%m-%Y'), '01-%m-%Y') as 'date', `month`, `total_amount` as 'quantity', `number_of_sales` as 'sales' from `sales_statistics_dates` order by date;");

                $quantity = [];
                $price = [];
                for ($i = 0; $i < count($query); $i++) {
                    $quantity[$i] = [
                        $query[$i]['date'],
                        intVal($query[$i]['quantity'],
                            $query[$i]['month'])
                    ];

                    $price[$i] = [
                        $query[$i]['date'],
                        floatVal($query[$i]['sales'],
                            $query[$i]['month'])
                    ];
                }

                header("HTTP/1.0 200 Ok.");
                return array(
                    'status' => 200,
                    'data' => array(
                        array(
                            'key' => 'Price',
                            'bar' => false,
                            'color' => '#333',
                            'values' => $quantity
                        ),
                        array(
                            'key' => 'Quantity',
                            'bar' => true,
                            'color' => '#ccf',
                            'values' => $price
                        )
                    )
                );
            }
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