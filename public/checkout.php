<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/checkout.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>受付終了</title>

</head>
<body>
    
    <nav class="header">
            <p>受付終了</p>
    </nav>

    <script>
        function updateReservation() {
            var r_num = document.getElementById("r_num").value;

            $.ajax({
                url: './db/checkoutdb.php', // バックエンドのPHPスクリプトのURL
                type: 'POST',
                data: { r_num: r_num },
                dataType: 'json',
                success: function(response) {
                    // 成功時と失敗時のメッセージを表示
                    if (response.success) {
                        alert(response.message);
                        location.href = "index.php";
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('エラーが発生しました: ' + error);
                }
            });
        }

        function validateInput(event) {
            // 入力が数字のみかどうか確認
            var input = event.target;
            if (!/^\d*$/.test(input.value)) {
                input.value = input.value.replace(/\D/g, ''); // 非数字を削除
            }
        }
        
    </script>

    
    <div class="containar">
        <div>
            <form onsubmit="event.preventDefault(); updateReservation();">
                <label for="r_num">受付終了する受付(予約)番号を入力してください。</label>
                <input type="text" id="r_num" name="r_num" title="受付番号"oninput="validateInput(event)" required>
                <button type="submit">送信</button>
            </form>
        </div>
    </div>
    
</body>
</html>