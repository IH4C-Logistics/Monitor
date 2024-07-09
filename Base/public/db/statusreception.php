<?php
// statusの値を1(準備完了)に変更

 require('dbpdo.php');

 session_start();
 $yoyaku = $_GET['yoyakuID'];

 $sql = ("UPDATE `t_reservation` SET `status`='1' WHERE contract_num = '".$yoyaku."'"); //SQL文

 // SQL実行
 $res = $dbh->prepare($sql);
 $res->execute();

 header('Location: ../loading.php');//URL飛ばす



?>