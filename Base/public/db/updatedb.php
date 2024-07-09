<?php

require('dbpdo.php');

// POSTで送られてきた予約番号の取得
$reserve_num = isset($_POST['reserve_num']) ? $_POST['reserve_num'] : '';

if (!empty($reserve_num)) {
    try {
        // SQL文の準備
        $sql = "UPDATE t_reservation SET status = '到着受付済' WHERE reserve_num = :reserve_num";
        $stmt = $dbh->prepare($sql);

        // パラメータのバインド
        $stmt->bindParam(':reserve_num', $reserve_num, PDO::PARAM_INT);

        // SQL実行
        $stmt->execute();

        // 成功メッセージを返す
        echo "到着予約が完了しました。";
    } catch (PDOException $e) {
        // エラーメッセージを返す
        echo "更新に失敗しました：" . $e->getMessage();
    }
} else {
    // 予約番号が空の場合のエラーメッセージを返す
    echo "予約番号が指定されていません。";
}
?>