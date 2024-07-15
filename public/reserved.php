<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/reserved.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <title>トップ</title>
    </head>
<body>

<div class="containar">
    <div>
        <form method="post" action="">
            <label for="r_num">予約番号を入力してください。</label>
            <input type="text" id="r_num" name="r_num" required>
            <button type="submit">送信</button>
        </form>
    </div>
</div>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $r_num = htmlspecialchars($_POST['r_num']);

        // reserveddb.phpを読み込み、データベースから情報を取得する
        // サーバーのホスト名を取得
        $host = $_SERVER['HTTP_HOST'];

        // スクリプトのパスを取得
        $script_path = dirname($_SERVER['SCRIPT_NAME']);

        // ベースURLを構築
        $base_url = "http://$host$script_path";

        // 相対パス
        $relative_path = '/db/reserveddb.php';

        $url = $base_url . $relative_path;

        $data = array('r_num' => $r_num);

        // cURLセッションの初期化
        $ch = curl_init($url);

        // オプションの設定
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        // リクエストを実行し、結果を取得
        $response = curl_exec($ch);

        // cURLセッションを終了
        curl_close($ch);

        // JSONを連想配列に変換
        $reservation = json_decode($response, true);
    }
?>

<?php if (isset($reservation) && !empty($reservation)): ?>
    <script>var showModal = true;</script>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>この予約内容でよろしいですか？</p>
            <p>受注No: <?php echo htmlspecialchars($reservation['contract_num']); ?></p>
            <p>運送会社: <?php echo htmlspecialchars($reservation['b_name']); ?></p>
            <p>到着地点: <?php echo htmlspecialchars($reservation['arrival_point']); ?></p>
            <p>到着日付: <?php echo htmlspecialchars($reservation['a_date']); ?></p>
            <p>到着予定時間: <?php echo htmlspecialchars($reservation['a_time']); ?></p>
            <p>運送会社名: <?php echo htmlspecialchars($reservation['trans_comp']); ?></p>
            <p>ドライバー名: <?php echo htmlspecialchars($reservation['driver_name']); ?></p>
            <p>電話番号: <?php echo htmlspecialchars($reservation['tel_num']); ?></p>
            <p>車両番号: <?php echo htmlspecialchars($reservation['car_num']); ?></p>
            <p>車格: <?php echo htmlspecialchars($reservation['vehicle_size']); ?></p>
            <p>品名等: <?php echo htmlspecialchars($reservation['product_name']); ?></p>
            <p>数量(ケース数): <?php echo htmlspecialchars($reservation['quantity']); ?></p>
            <button id="updateButton" data-contract-num="<?php echo htmlspecialchars($reservation['contract_num']); ?>">予約受付</button>
        </div>
    </div>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p>入力された予約番号は見つかりませんでした。</p>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var showModal = <?php echo isset($reservation) ? 'true' : 'false'; ?>;
        if (showModal) {
            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];
            var updateButton = document.getElementById("updateButton");

            modal.style.display = "block";

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // ボタンがクリックされたときの処理
            updateButton.addEventListener("click", function() {
                var reserveNum = updateButton.getAttribute('data-contract-num'); // ボタンに設定された予約番号を取得

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "db/updatedb.php", true); // 更新用のPHPファイル
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // 更新が成功した場合の処理
                            alert("予約を受け付けました。");
                            modal.style.display = "none"; // モーダルを非表示にするなどの処理を追加することも可能
                            // index.phpにリダイレクト
                            location.href = "index.php";
                        } else {
                            // 更新が失敗した場合の処理
                            alert("更新に失敗しました。");
                        }
                    }
                };
                xhr.send("contract_num=" + encodeURIComponent(reserveNum)); // 更新する予約番号を送信する
            });
        }
    });
</script>

</body>
</html>
