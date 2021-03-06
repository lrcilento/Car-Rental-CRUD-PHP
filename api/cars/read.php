<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../models/cars.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Car($db);

    $stmt = $items->getCar();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount);

    if($itemCount > 0){
        
        $carArr = array();
        $carArr["body"] = array();
        $carArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "plate" => $plate,
                "model" => $model,
                "year" => $year,
                "color" => $color,
                "dailyRate" => $dailyRate,
                "rentStatus" => $rentStatus
            );

            array_push($carArr["body"], $e);
        }
        echo json_encode($carArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>