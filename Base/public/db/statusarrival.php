<?php
// statusの値を0(到着受付)に変更

 require('dbpdo.php');

 session_start();
 $yoyaku = $_GET['yoyakuID'];

 $sql = ("UPDATE `t_reservation` SET `status`='0' WHERE contract_num = '".$yoyaku."'"); //SQL文

 // SQL実行
 $res = $dbh->prepare($sql);
 $res->execute();

 header('Location: ../loading.php');//URL飛ばす



?>