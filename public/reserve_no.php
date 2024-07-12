<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reserve_no.css">
    <title>フォーム入力</title>

</head>
<body>
    <h2>受付情報入力画面</h2>
    <form id="inputForm">

        <!-- 入力フォームの項目 -->
        <label for="date">作業日選択してください</label><br>
        <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label for="p_num">携帯番号を入力してください</label><br>
        <input type="text" id="p_num" name="p_num" required><br><br>

        <label for="b_name">運送会社を入力してください</label><br>
        <input type="text" id="b_name" name="b_name" required><br><br>

        <label for="b_driver">ドライバー名を入力してください</label><br>
        <input type="text" id="b_driver" name="b_driver" required><br><br>

        <label for="car_num">車両番号を入力してください</label><br>
        <input type="text" id="car_num" name="car_num" required><br><br>

        <label for="Vehicle_size">車格を選択してください。</label><br>       
        <select name="Vehicle_size" id="Vehicle_size">
            <option value="2トン車">2トン車</option>
            <option value="4トン車">4トン車</option>
            <option value="10トン車">10トン車</option>
            <option value="トレーラー">トレーラー</option>
            <option value="軽トラック">軽トラック</option>
            <option value="JRコンテナ">JRコンテナ</option>
        </select><br><br>

        <label for="product_name">名義/メーカ名/品名等を入力してください。100文字まで入力できます。</label><br>
        <input type="text" id="product_name" name="product_name" maxlength="100" required><br><br>

        <label for="case">個数(ケース数)を入力して下さい</label><br>
        <input type="text" id="case" name="case" required><br><br>

        <input type="button" id="openModalButton" value="受付">
    </form>

    <!-- モーダルウィンドウのコード -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>入力内容確認</h2>
            <p id="modalDate"></p>
            <p id="modalPNum"></p>
            <p id="modalBName"></p>
            <p id="modalBDriver"></p>
            <p id="modalCarNum"></p>
            <p id="modalVehicleSize"></p>
            <p id="modalProductName"></p>
            <p id="modalCase"></p>
            <p id="modalRandomNumber"></p>
            <button id="confirmButton">上記の内容で受付をする。</button>
            <button id="navigateButton" style="display: none;">受付番号を確認しました。</button>
        </div>
    </div>

    <script>
        document.getElementById('openModalButton').addEventListener('click', function(event) {
            event.preventDefault();

            // フォームのデータを取得
            var date = document.getElementById('date').value;
            var p_num = document.getElementById('p_num').value;
            var b_name = document.getElementById('b_name').value;
            var b_driver = document.getElementById('b_driver').value;
            var car_num = document.getElementById('car_num').value;
            var vehicle_size = document.getElementById('Vehicle_size').value;
            var product_name = document.getElementById('product_name').value;
            var case_num = document.getElementById('case').value;

                // 入力チェック
            if (date === '' || p_num === '' || b_name === '' || b_driver === '' || car_num === '' || vehicle_size === '' || product_name === '' || case_num === '') {
                alert('全ての項目を入力してください。');
                return;
            }

            // モーダルにデータをセット
            document.getElementById('modalDate').innerText = '作業日: ' + date;
            document.getElementById('modalPNum').innerText = '携帯番号: ' + p_num;
            document.getElementById('modalBName').innerText = '運送会社: ' + b_name;
            document.getElementById('modalBDriver').innerText = 'ドライバー名: ' + b_driver;
            document.getElementById('modalCarNum').innerText = '車両番号: ' + car_num;
            document.getElementById('modalVehicleSize').innerText = '車格: ' + vehicle_size;
            document.getElementById('modalProductName').innerText = '品名等: ' + product_name;
            document.getElementById('modalCase').innerText = '個数: ' + case_num;

            // モーダルを表示
            var modal = document.getElementById('myModal');
            modal.style.display = 'block';
        });

        document.getElementById('confirmButton').addEventListener('click', function() {
            event.preventDefault(); // デフォルトの送信動作を防止する
            // フォームデータの取得
            var date = document.getElementById('date').value;
            var p_num = document.getElementById('p_num').value;
            var b_name = document.getElementById('b_name').value;
            var b_driver = document.getElementById('b_driver').value;
            var car_num = document.getElementById('car_num').value;
            var vehicle_size = document.getElementById('Vehicle_size').value;
            var product_name = document.getElementById('product_name').value;
            var case_num = document.getElementById('case').value;

            // データの送信
            fetch('/program/LOGISTICS/Monitor/public/db/reserve_no_db.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'date': date,
                    'p_num': p_num,
                    'b_name': b_name,
                    'b_driver': b_driver,
                    'car_num': car_num,
                    'Vehicle_size': vehicle_size,
                    'product_name': product_name,
                    'case': case_num
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error + ': ' + data.details);
                } else {
                    document.getElementById('modalRandomNumber').innerText = 'あなたの受付番号は: ' + data.random_number + 'です。';
                    document.getElementById('confirmButton').style.display = 'none';
                    document.getElementById('navigateButton').style.display = 'block';
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });


        });

        // モーダルを閉じるボタン
        document.querySelector('.close').onclick = function() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }

        // 「遷移する」ボタンのクリックイベント
        document.getElementById('navigateButton').onclick = function() {
            window.location.href = 'http://localhost/program/LOGISTICS/Monitor/public'; // 遷移するURLを指定する
        }

        // モーダル外をクリックした場合にモーダルを閉じる処理
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
