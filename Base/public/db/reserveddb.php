<?php
  require('dbpdo.php');

    // POSTで送られてきたr_numを取得
    $r_num = htmlspecialchars($_POST['r_num']);

    // SQLクエリの準備と実行
    $sql = "SELECT * FROM t_reservation WHERE reserve_num = :r_num";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':r_num', $r_num);
    $statement->execute();

    // 結果を取得
    $reservation = $statement->fetch(PDO::FETCH_ASSOC);

    // 結果をJSON形式で出力
    echo json_encode($reservation);


?>