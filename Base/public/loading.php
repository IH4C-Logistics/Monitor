<?php

try{

require('db/dbpdo.php');
session_start();

$name = "エルフーズ横須賀工場";

$sql1 = "SELECT * FROM t_reservation WHERE b_name = '".$name."'";
$stmt1 = $dbh->prepare($sql1);  
$stmt1->execute();
$name1 = $stmt1->fetchAll();
 
// $sql = ("SELECT * FROM t_reservation where 1"); 
// $stmt = $dbh->prepare($sql);
// $stmt->execute();
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 $sql = ("SELECT * FROM `t_reservation` ORDER BY CAST(`a_time` AS TIME) ASC"); 
 $stmt = $dbh->prepare($sql);
 $stmt->execute();
 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql2 = ("SELECT * FROM t_reservation where status = '1'"); 
$stmt2 = $dbh->prepare($sql2);
$stmt2->execute();
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


}catch (PDOException $e) {
  exit('データベースに接続できませんでした。' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/loading.css">
  <title>積込状況管理</title>
</head>
<body>

  <nav class="header">
    <a href="index.php" class="home">HOME</a>
  </nav>

  
  <div class="container">
    <div>
      <div class="first">
        <p>以下の番号の方は、</br>受付にお声掛けください</p>
        <div class="firsttable">
          <table id="reservationTable">
            <tr>
              <th>予約番号</th>
            </tr>
            <?php foreach ($result2 as $item): ?>
            <tr><td><?php echo $item['contract_num']; ?></td></tr>
            <?php endforeach; ?>
            <tr>
              <td id="pagenumber">1/1ページ</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="second">
        <h2>A物流拠点</h2>
        <div class="secondtable">
          <table id="arrivalTable">
              <tr>
                  <th>到着予定</th>
                  <th>予約番号</th>
                  <th>ステータス</th>
                  <th></th>
              </tr>
              <?php foreach ($result as $item): ?>
              <tr>
                <td id="kisu"><?php echo $item['a_time'];       ?></td>
                <td id="kisu"><?php echo $item['contract_num']; ?></td>
                <td id="kisu" class="situation">

                <?php 
                $status = $item['status'];
                $yoyaku = $item['contract_num'];
                  switch($status){
                    case 0:
                      echo "到着受付";?>
                      <a href="db/statusreception.php?yoyakuID=<?php echo $yoyaku; ?>" class="button"><img src="images/24960681.png" alt="change"></a>
                </td>
                <?php 
                    break;
                  case 1:
                    echo "準備完了";?>
                    <a href="db/statusarrival.php?yoyakuID=<?php echo $yoyaku; ?>" class="button"><img src="images/24960681.png" alt="change"></a>
              <?php break;}
                ?>

                <td id="kisu">しばらくお待ちください。</td>
              </tr>
              <?php endforeach; ?>
              <tr>
              <td colspan="4" id="pagenumber">1/1ページ</td>
              </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- <script>
    function toggleStatus(button) {
    // ボタンの親要素の<td>を取得
    var td = button.parentNode;
    
    // 現在の状態を取得
    var currentStatus = td.childNodes[0].nodeValue.trim();
    
    // 状態を切り替え
    if (currentStatus === "到着受付") {
        td.childNodes[0].nodeValue = "準備完了";
    } else {
        td.childNodes[0].nodeValue = "到着受付";
    }
    }-->

    <script>
    document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("reservationTable");
    var rows = table.getElementsByTagName("tr");
    
    // Get the number of rows excluding the header and footer
    var dataRows = rows.length - 2; // 1 for header, 1 for footer

    // Calculate how many empty rows are needed
    var emptyRowsNeeded = 9 - dataRows;

    // Add empty rows if needed
    for (var i = 0; i < emptyRowsNeeded; i++) {
        var newRow = table.insertRow(rows.length - 1); // Insert before the last row (footer)
        var newCell = newRow.insertCell(0);
        newCell.innerHTML = "&nbsp;"; // Use non-breaking space for empty cell
    }
    });

    document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("arrivalTable");
    var rows = table.getElementsByTagName("tr");
    
    var dataRows = rows.length - 2; // 1 for header, 1 for footer

    var emptyRowsNeeded = 10 - dataRows;

    for (var i = 0; i < emptyRowsNeeded; i++) {
        var newRow = table.insertRow(rows.length - 1); // Insert before the last row (footer)
        for (var j = 0; j < 4; j++) {
            var newCell = newRow.insertCell(j);
            newCell.innerHTML = "&nbsp;"; // Use non-breaking space for empty cell
        }
    }
    });
</script> 

</body>
</html>