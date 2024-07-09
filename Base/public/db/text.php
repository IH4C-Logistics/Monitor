<?php
$partner = $_POST['test'];
  require('dbpdo.php');
  $text = $_POST['text'];
  $sql = "INSERT INTO `t_chat` (`player`, `c_Partner`, `time`, `text`) VALUES ('1', '".$partner."', NOW(), '".$text."')";  //SQL文

  // SQL実行
  $res = $dbh->prepare($sql);
  $res->execute();

 // header('Location: ../chat.php');//URL飛ばす

header('Location: ../chat.php?userID=' . $partner);

?>