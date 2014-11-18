<?php

class CameraCrud {
    static public function create_camera () {
        API :: AddCORSHeaders();

        $args           = json_decode(file_get_contents('php://input'));
        $brand          = $args -> brand;
        $model_name     = $args -> model_name;
        $price          = $args -> price;
        $battery        = $args -> battery_type;
        $megapixels     = $args -> megapixels;
        $can_do_video   = $args -> can_do_video;
        $has_flash      = $args -> has_flash;
        $resolution     = $args -> resolution;
        $type_id        = $args -> type_id;
        $storage_id     = $args -> storage_id;

        $error = API :: CheckAuth("write");

        if ($error !== null) {
            return $error;
        } else {
            $cameraId = getDatabase()->execute(
                'INSERT INTO `cameras`(brand, model_name, price, battery_type, megapixels, can_do_video, has_flash, resolution, type_id, storage_id)
                 VALUES(:brand, :model_name, :price, :battery_type, :megapixels, :can_do_video, :has_flash, :resolution, :type_id, :storage_id)',
                 array(
                    ':brand' => $brand, ':model_name' => $model_name, ':price' => $price,
                    ':battery_type' => $battery, ':megapixels' => $megapixels,
                     ':can_do_video' => $can_do_video, ':has_flash' => $has_flash, ':resolution' => $resolution, ':type_id' => $type_id,
                    ':storage_id' => $storage_id )
            );

            return array(
                'status' => 201,
                'camera_id' => $cameraId
            );
        }
    }

    static public function update_camera ($id) {
        API :: AddCORSHeaders();

        $args           = json_decode(file_get_contents('php://input'));
        $brand          = $args -> brand;
        $model_name     = $args -> model_name;
        $price          = $args -> price;
        $battery        = $args -> battery_type;
        $megapixels     = $args -> megapixels;
        $can_do_video   = $args -> can_do_video;
        $has_flash      = $args -> has_flash;
        $resolution     = $args -> resolution;
        $type_id        = $args -> type_id;
        $storage_id     = $args -> storage_id;

        $error = API :: CheckAuth("update");

        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute('UPDATE `cameras` SET `brand`=:brand, `model_name`=:model_name, `price`=:price, `battery_type`=:battery_type, `megapixels`=:megapixels, `can_do_video`=:can_do_video, `has_flash`=:has_flash, `resolution`=:resolution, `type_id`=:type_id, `storage_id`=:storage_id WHERE `id` IN (:id)',
                array(
                    ':brand' => $brand, ':model_name' => $model_name, ':price' => $price,
                    ':battery_type' => $battery, ':megapixels' => $megapixels,
                    ':can_do_video' => $can_do_video, ':has_flash' => $has_flash, ':resolution' => $resolution, ':type_id' => $type_id,
                    ':storage_id' => $storage_id, ':id' => $id )
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
     * Gets the list of available camera cameras
     * @return json
     */
    static public function read_camera () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");

        if ($error !== null) {
            return $error;
        } else {
            $camera = getDatabase()->all("SELECT * FROM cameras;");

            return array(
                'status' => 200,
                'camera_camera' => $camera
            );
        }
    }

    static public function popular_camera_in_country ($country) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");


        if ($error !== null) {
            return $error;
        } else {
            $cameras = getDatabase() -> all("select `camera` as label, sales as value from `cameras_top` where country = :country;", array(':country' => $country));

            for ($i=0;$i<count($cameras);$i++) {
                $cameras[$i]['value'] = intval($cameras[$i]['value']);
            }

            header("HTTP/1.0 200 OK");
            return array(
                'status' => 200,
                'data' => $cameras
            );
        }
    }

    static public function cameras_sold_per_month_per_brand () {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("read");


        if ($error !== null) {
            return $error;
        } else {
            $cameras = getDatabase() -> all("select brand, month, sales from sales_per_brand_per_month order by brand, date;");

            $last = $cameras[0]['brand'];
            $result = array();
            $section = array();
            $section['key'] = $last;
            $section['values'] = [];

            for ($i=0;$i<count($cameras);$i++) {
                if ($last !== $cameras[$i]['brand']) {
                    array_push($result, $section);

                    $last = $cameras[$i]['brand'];
                    $section = array();
                    $section['key'] = $last;
                    $section['values'] = [];
                }

                array_push($section['values'], [
                    $cameras[$i]['month'],
                    intval($cameras[$i]['sales'])
                ]);
            }

            array_push($result, $section);

            header("HTTP/1.0 200 OK");
            return array(
                'status' => 200,
                'data' => $result
            );
        }
    }

    static public function delete_camera ($id) {
        API :: AddCORSHeaders();

        $error = API :: CheckAuth("delete");


        if ($error !== null) {
            return $error;
        } else {
            $affectedRows = getDatabase()->execute("DELETE FROM `cameras` WHERE `id` IN (:id)", array(':id' => $id));

            header("HTTP/1.0 202 Accepted");
            return array(
                'status' => 202,
                'deleted' => $affectedRows
            );
        }
    }
} 