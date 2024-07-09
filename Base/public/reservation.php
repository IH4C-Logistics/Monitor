<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reservation.css">
  <title>予約状況管理</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

  <nav class="header">
    <a href="index.php" class="home">HOME</a>
    <a class="res_window">新規予約</a>
  </nav>
  
<?php
  // データベース情報
  $host = "localhost"; // データベースのホスト名
  $username = "root"; // データベースのユーザー名
  $password = ""; // データベースのパスワード
  $dbname= "ih4c"; // 使用するデータベース名

  try {
    // データベース接続情報
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データベースから既存の予約を取得
    $stmt = $pdo->prepare("SELECT * FROM t_reservation");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

  <div class="modal"></div>
    <div class="res_modal">
      <h2 class="title2">予約情報追加</h2>
      <form method="post" action="" enctype="multipart/form-data">
        <div class="form-container">
          <div>
            <label for="textbox1">運送会社</label>
            <input type="text" name="b_name" id="textbox1">
          </div>
          <div>
            <label for="textbox2">数量</label>
            <input type="text" name="total_quantity" id="textbox2">
          </div>
          <div>
            <label for="textbox3">重量(kg)</label>
            <input type="text" name="total_weight_kg" id="textbox3">
          </div>
          <div>
            <label for="textbox4">車番</label>
            <input type="text" name="car_num" id="textbox4">
          </div>
          <div>
            <label for="textbox5">受注No</label>
            <input type="text" name="contract_num" id="textbox5">
          </div>
          <div>
            <label for="textbox6">発地</label>
            <input type="text" name="departure_point" id="textbox6">
          </div>
          <div>
            <label for="textbox7">発日付</label>
            <input type="text" name="d_date" id="textbox7">
          </div>
          <div>
            <label for="textbox8">発時間</label>
            <input type="text" name="d_time" id="textbox8">
          </div>
          <div>
            <label for="textbox9">着地</label>
            <input type="text" name="arrival_point" id="textbox9">
          </div>
        </div>
        <div class="form-container2">
            <div>
              <label for="textbox10">着日付</label>
              <input type="text" name="a_date" id="textbox10">
            </div>
            <div>
              <label for="textbox11">着時間</label>
              <input type="text" name="a_time" id="textbox11">
            </div>
            <div>
              <label for="textbox12">温度</label>
              <input type="text" name="temperature" id="textbox12">
            </div>
            <div>
              <label for="textbox13">荷主名</label>
              <input type="text" name="shipper_name" id="textbox13">
            </div>
            <div>
              <label for="textbox14">品名</label>
              <input type="text" name="product_name" id="textbox14">
            </div>
            <div>
              <label for="textbox15">規格</label>
              <input type="text" name="standard" id="textbox15">
            </div>
            <div>
              <label for="textbox16">数量</label>
              <input type="text" name="quantity" id="textbox16">
            </div>
            <div>
              <label for="textbox17">重量(kg)</label>
              <input type="text" name="weight_kg" id="textbox17">
            </div>
            <div>
              <label for="textbox18">予約ステータス</label>
              <input type="text" name="status" id="textbox18">
            </div>
            <div>
              <button class="button" type="submit">登録</button>
            </div>
        </div>
      </form>
    </div>

    <div class="con">
    <div>
      <h2 class="title">現在予約済みの予約情報</h2>
      <div class="scrollable-container">
        <?php if (isset($result) && count($result) > 0): ?>
          <table>
            <tr>
              <?php foreach ($result[0] as $key => $value): ?>
                <?php
                  switch ($key) {
                    case 'b_name':
                      $header = '運送会社';
                      break;
                    case 'total_quantity':
                      $header = '数量';
                      break;
                    case 'total_weight_kg':
                      $header = '重量(kg)';
                      break;
                    case 'car_num':
                      $header = '車番';
                      break;
                    case 'contract_num':
                      $header = '受注No';
                      break;
                    case 'departure_point':
                      $header = '発地';
                      break;
                    case 'd_date':
                      $header = '発日付';
                      break;
                    case 'd_time':
                      $header = '発時間';
                      break;
                    case 'arrival_point':
                      $header = '着地';
                      break;
                    case 'a_date':
                      $header = '着日付';
                      break;
                    case 'a_time':
                      $header = '着時間';
                      break;
                    case 'temperature':
                      $header = '温度';
                      break;
                    case 'shipper_name':
                      $header = '荷主名';
                      break;
                    case 'product_name':
                      $header = '品名';
                      break;
                    case 'standard':
                      $header = '規格';
                      break;
                    case 'quantity':
                      $header = '数量';
                      break;
                    case 'weight_kg':
                      $header = '重量(kg)';
                      break;
                    case 'status':
                      $header = '予約状況';
                      break;
                    default:
                      $header = $key;
                      break;
                  }
                ?>
                <th><?php echo htmlspecialchars($header); ?></th>
              <?php endforeach; ?>
            </tr>
            <?php foreach ($result as $row): ?>
              <tr>
                <?php foreach ($row as $value): ?>
                  <td><?php echo htmlspecialchars(mb_substr($value, 0, 20)); ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </table>
        <?php else: ?>
          データがありません。
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php
    // フォームが送信されたかどうかを確認
    if ($_SERVER["REQUEST_METHOD"] == "POST" && 
        isset($_POST['b_name'], $_POST['total_quantity'], $_POST['total_weight_kg'], $_POST['car_num'], 
              $_POST['contract_num'], $_POST['departure_point'], $_POST['d_date'], $_POST['d_time'], 
              $_POST['arrival_point'], $_POST['a_date'], $_POST['a_time'], $_POST['temperature'], 
              $_POST['shipper_name'], $_POST['product_name'], $_POST['standard'], $_POST['quantity'], 
              $_POST['weight_kg'], $_POST['status'])) {

        $b_name = $_POST['b_name'];
        $total_quantity = $_POST['total_quantity'];
        $total_weight_kg = $_POST['total_weight_kg'];
        $car_num = $_POST['car_num'];
        $contract_num = $_POST['contract_num'];
        $departure_point = $_POST['departure_point'];
        $d_date = $_POST['d_date'];
        $d_time = $_POST['d_time'];
        $arrival_point = $_POST['arrival_point'];
        $a_date = $_POST['a_date'];
        $a_time = $_POST['a_time'];
        $temperature = $_POST['temperature'];
        $shipper_name = $_POST['shipper_name'];
        $product_name = $_POST['product_name'];
        $standard = $_POST['standard'];
        $quantity = $_POST['quantity'];
        $weight_kg = $_POST['weight_kg'];
        $status = $_POST['status'];

        // t_reservationテーブルに入力した内容を追加
        $queryins = "INSERT INTO t_reservation(b_name, total_quantity, total_weight_kg, car_num, contract_num, departure_point, d_date, d_time, arrival_point, a_date, a_time, temperature, shipper_name, product_name, standard, quantity, weight_kg, status)
                    VALUES (:b_name, :total_quantity, :total_weight_kg, :car_num, :contract_num, :departure_point, :d_date, :d_time, :arrival_point, :a_date, :a_time, :temperature, :shipper_name, :product_name, :standard, :quantity, :weight_kg, :status)";
        $statement = $pdo->prepare($queryins);
        $statement->bindParam(':b_name', $b_name);
        $statement->bindParam(':total_quantity', $total_quantity);
        $statement->bindParam(':total_weight_kg', $total_weight_kg);
        $statement->bindParam(':car_num', $car_num);
        $statement->bindParam(':contract_num', $contract_num);
        $statement->bindParam(':departure_point', $departure_point);
        $statement->bindParam(':d_date', $d_date);
        $statement->bindParam(':d_time', $d_time);
        $statement->bindParam(':arrival_point', $arrival_point);
        $statement->bindParam(':a_date', $a_date);
        $statement->bindParam(':a_time', $a_time);
        $statement->bindParam(':temperature', $temperature);
        $statement->bindParam(':shipper_name', $shipper_name);
        $statement->bindParam(':product_name', $product_name);
        $statement->bindParam(':standard', $standard);
        $statement->bindParam(':quantity', $quantity);
        $statement->bindParam(':weight_kg', $weight_kg);
        $statement->bindParam(':status', $status);
        $statement->execute();

    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo '値が入力されていません';
        }
    }

  } catch (PDOException $e) {
    echo 'データベース接続エラー: ' . $e->getMessage();
  }
  ?>

  <script>
      $(document).on('click', '.res_window', function() {
          // 背景をスクロールできないように & スクロール場所を維持
          scroll_position = $(window).scrollTop();
          $('body').addClass('fixed').css({ 'top': -scroll_position });
          // モーダルウィンドウを開く
          $('.res_modal').fadeIn();
          $('.modal').fadeIn();
      });

      $(document).on('click', '.modal', function() {
          // 背景スクロールを再開し、モーダルを閉じる
          $('body').removeClass('fixed').css({ 'top': '' });
          $(window).scrollTop(scroll_position);
          $('.res_modal').fadeOut();
          $('.modal').fadeOut();
      });
  </script>

</body>
</html>
