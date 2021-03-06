<?php

    session_start();

    if(isset($_SESSION['type_id'])) {

        require_once('../controls/config.php');

        require_once('../controls/connection.php');

        if(isset($_POST['brand'])) {

            $slog = strtolower($_POST['brand'][0]['value']);

            $exist = "SELECT brand_id FROM tbl_brand WHERE brand_name = '".$slog."'";

            $queryexist = mysqli_query($connection, $exist);

            if($queryexist->num_rows == 0) {

                $brand = '';

                foreach ($_POST['brand'] as $key => $info) {

                    $brand .= "'".$info['value']."'";

                    if($info !== end($_POST['brand'])) {

                        $brand .= ', ';

                    }

                }

                $date = $_POST['brand'][9]['value'];

                $effectiveDate = date('Y-m-d', strtotime("+3 months"));

                if(strtotime($date) > strtotime($effectiveDate))  {

                    $insert = "tbl_brand(`brand_name`, `variant_id`, `generic_code`, `dosage_code`, `category_code`, `brand_qtyperbox`, `brand_qtyperpiece`, `brand_priceperpiece`,";
                    $insert .= " `brand_priceperbox`, `brand_expiration`, `brand_holdingcost`, `brand_orderingcost`, `brand_totalqtyperbox`, `brand_supplier`)";

                    $query = "INSERT INTO ".$insert." VALUES(".$brand.")";

                    $sql = mysqli_query($connection, $query);

                    if((int) $sql === 1) {

                        echo 'success';

                    } else {

                        echo 'id-error';

                    }

                } else {

                    echo 'invalid-date';

                }

            } else {

                echo 'exist';

            }

        } else {

            echo 'id-error';

        }

    } else {

        echo 'invalid';

    }

?>
