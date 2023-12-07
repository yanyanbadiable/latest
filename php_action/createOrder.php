<?php

require_once 'core.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$valid = array('success' => false, 'messages' => array(), 'order_id' => '');

if ($_POST) {
    // Check if the key "orderDate" exists in $_POST
    $orderDate = isset($_POST['orderDate']) ? date('Y-m-d', strtotime($_POST['orderDate'])) : null;

    // Check if other required keys exist in $_POST
    if (isset(
        $_POST['subTotalValue'],
        $_POST['totalAmountValue'],
        $_POST['discount'],
        $_POST['grandTotalValue'],
        $_POST['paid'],
        $_POST['dueValue'],
        $_POST['productName'],
        $_POST['quantity'],
        $_POST['rateValue'],
        $_POST['totalValue']
    )) {
        $subTotalValue = $_POST['subTotalValue'];
        $totalAmountValue = $_POST['totalAmountValue'];
        $discount = $_POST['discount'];
        $grandTotalValue = $_POST['grandTotalValue'];
        $paid = $_POST['paid'];
        $dueValue = $_POST['dueValue'];

        $sql = "INSERT INTO orders (order_date, sub_total, total_amount, discount, grand_total, paid, due, order_status) VALUES ('$orderDate', '$subTotalValue', '$totalAmountValue', '$discount', '$grandTotalValue', '$paid', '$dueValue', 1)";

        $order_id;
        $orderStatus = false;

        if ($connect->query($sql) === true) {
            $order_id = $connect->insert_id;
            $valid['order_id'] = $order_id;

            $orderStatus = true;
        }

        // echo $_POST['productName'];
        $orderItemStatus = false;

        for ($x = 0; $x < count($_POST['productName']); $x++) {
            $updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = " . $_POST['productName'][$x] . "";
            $updateProductQuantityData = $connect->query($updateProductQuantitySql);

            while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
                $updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];

                // update product table
                $updateProductTable = "UPDATE product SET quantity = '" . $updateQuantity[$x] . "' WHERE product_id = " . $_POST['productName'][$x] . "";
                $connect->query($updateProductTable);

                // add into order_item
                $orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
                VALUES ('$order_id', '" . $_POST['productName'][$x] . "', '" . $_POST['quantity'][$x] . "', '" . $_POST['rateValue'][$x] . "', '" . $_POST['totalValue'][$x] . "', 1)";

                $connect->query($orderItemSql);

                if ($x == count($_POST['productName']) - 1) {
                    $orderItemStatus = true;
                }
            } // while
        } // /for quantity

        $valid['success'] = true;
        $valid['messages'] = "Successfully Added";

        $connect->close();

        echo json_encode($valid);
    } else {
        $valid['messages'][] = "Missing required fields in the POST data.";
        echo json_encode($valid);
    }
} else {
    $valid['messages'][] = "No POST data received.";
    echo json_encode($valid);
}
?>
