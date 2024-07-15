<?php
require('dbpdo.php');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTで送られてきたr_numを取得
    if (isset($_POST['r_num']) && !empty($_POST['r_num'])) {
        $r_num = htmlspecialchars($_POST['r_num']);

        try {
            // 契約番号が存在するか確認
            $sql_check = "SELECT status FROM t_reservation WHERE contract_num = :r_num";
            $statement_check = $dbh->prepare($sql_check);
            $statement_check->bindParam(':r_num', $r_num);
            $statement_check->execute();

            $reservation = $statement_check->fetch(PDO::FETCH_ASSOC);

            if ($reservation) {
                if ($reservation['status'] == '4') {
                    $response['success'] = true;
                    $response['message'] = 'この受付番号は既に受付を終了しています。';
                } else {
                    // ステータスを更新
                    $sql_update = "UPDATE t_reservation SET status = '4' WHERE contract_num = :r_num";
                    $statement_update = $dbh->prepare($sql_update);
                    $statement_update->bindParam(':r_num', $r_num);
                    $statement_update->execute();

                    $rowCount = $statement_update->rowCount();

                    if ($rowCount > 0) {
                        $response['success'] = true;
                        $response['message'] = '受付番号' . $r_num.'はチェックアウトを完了しました。';
                    } else {
                        $response['success'] = false;
                        $response['message'] = '受付終了に失敗しました。';
                    }
                }
            } else {
                $response['success'] = false;
                $response['message'] = '受付番号 ' . $r_num . ' が見つかりませんでした。もう一度ご確認ください。';
            }
        } catch (PDOException $e) {
            $response['success'] = false;
            $response['message'] = 'データベースエラー: ' . $e->getMessage() . ' (契約番号: ' . $r_num . ')';
        }
    } else {
        $response['success'] = false;
        $response['message'] = '受付番号が入力されていません。';
    }
} else {
    $response['success'] = false;
    $response['message'] = '無効なリクエストです。';
}

// 結果をJSON形式で出力
echo json_encode($response);
?>
