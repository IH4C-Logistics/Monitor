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

<div>
    <h2>予約済受付画面</h2>
    <form method="post" action="">
        <label for="r_num">予約番号を入力してください。</label>
        <input type="text" id="r_num" name="r_num" required>
        <button type="submit">送信</button>
    </form>
</div>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $r_num = htmlspecialchars($_POST['r_num']);

        // reserveddb.phpを読み込み、データベースから情報を取得する
        $url = 'http://localhost/Base/public/db/reserveddb.php'; // reserveddb.phpのURL
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

        if ($reservation) {
            echo '<script>var showModal = true;</script>';
            echo '<div id="myModal" class="modal">';
            echo '<div class="modal-content">';
            echo '<span class="close">&times;</span>';
            echo '<p>この予約内容でよろしいですか？</p>';
            echo '<p>予約番号: ' . htmlspecialchars($reservation['reserve_num']) . '</p>';
            echo '<p>運送会社: ' . htmlspecialchars($reservation['b_name']) . '</p>';
            echo '<p>車両番号: ' . htmlspecialchars($reservation['car_num']) . '</p>';
            echo '<p>受注No: ' . htmlspecialchars($reservation['contract_num']) . '</p>';
            echo '<p>出発地点: ' . htmlspecialchars($reservation['departure_point']) . '</p>';
            echo '<p>到着地点: ' . htmlspecialchars($reservation['arrival_point']) . '</p>';
            echo '<p>保存温度: ' . htmlspecialchars($reservation['temperature']) . '</p>';
            echo '<p>荷主名: ' . htmlspecialchars($reservation['shipper_name']) . '</p>';

            //完了ボタン
            echo '<button id="updateButton" data-reserve-num="' . htmlspecialchars($reservation['reserve_num']) . '">予約受付</button>';

        } else {
            echo '<p>入力された予約番号は見つかりませんでした。</p>';
        }
    } else {
        echo '';
    }
?>



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
                var reserveNum = updateButton.getAttribute('data-reserve-num'); // ボタンに設定された予約番号を取得

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "db/updatedb.php", true); // 更新用のPHPファイル
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // 更新が成功した場合の処理
                            alert("予約を受け付けました。");
                            modal.style.display = "none"; // モーダルを非表示にするなどの処理を追加することも可能
                        } else {
                            // 更新が失敗した場合の処理
                            alert("更新に失敗しました。");
                        }
                    }
                };
                xhr.send("reserve_num=" + encodeURIComponent(reserveNum)); // 更新する予約番号を送信する
            });
        }
    });
</script>




</body>
</html>