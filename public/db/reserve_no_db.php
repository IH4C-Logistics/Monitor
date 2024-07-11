<?php

    require('dbpdo.php');

    // POSTで送られてきた情報の取得
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $p_num = isset($_POST['p_num']) ? $_POST['p_num'] : '';
    $b_name = isset($_POST['b_name']) ? $_POST['b_name'] : '';
    $b_driver = isset($_POST['b_driver']) ? $_POST['b_driver'] : '';
    $car_num = isset($_POST['car_num']) ? $_POST['car_num'] : '';
    $Vehicle_size = isset($_POST['Vehicle_size']) ? $_POST['Vehicle_size'] : '';
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $case = isset($_POST['case']) ? $_POST['case'] : '';

    // ランダムな10桁の数字を生成する関数
    function generateRandomNumber($length = 10) {
        $number = '';
        for ($i = 0; $i < $length; $i++) {
            $number .= mt_rand(0, 9);
        }
        return $number;
    }

    // 10桁のランダムな数字を生成して変数に格納
    $random_number = generateRandomNumber();

    try {
        // SQL文の準備
        $sql = "INSERT INTO t_reserve_no (random_number, `date`, p_num, b_name, b_driver, car_num, Vehicle_size, product_name, `case`,status) 
                VALUES (:random_number, :date, :p_num, :b_name, :b_driver, :car_num, :Vehicle_size, :product_name, :case,0)";

        $stmt = $dbh->prepare($sql);

        // パラメータのバインド
        $stmt->bindParam(':random_number', $random_number, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':p_num', $p_num, PDO::PARAM_STR);
        $stmt->bindParam(':b_name', $b_name, PDO::PARAM_STR);
        $stmt->bindParam(':b_driver', $b_driver, PDO::PARAM_STR);
        $stmt->bindParam(':car_num', $car_num, PDO::PARAM_STR);
        $stmt->bindParam(':Vehicle_size', $Vehicle_size, PDO::PARAM_STR);
        $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $stmt->bindParam(':case', $case, PDO::PARAM_STR);

        // SQL実行
        $stmt->execute();

        // 成功メッセージとランダムナンバーをクライアントに返す
        echo json_encode(array('message' => '予約が完了しました。あなたの受付番号は' . $random_number.'です。okを押して以下の番号を確認してください。', 'random_number' => $random_number));

    } catch (PDOException $e) {
        // エラーメッセージをクライアントに返す
        echo json_encode(array('error' => '予約に失敗しました。', 'details' => $e->getMessage()));
    }

?>
