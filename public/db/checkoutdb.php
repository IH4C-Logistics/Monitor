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
                    $response['message'] = 'この受付番号は既に予約を完了しています。';
                } else {
                    // ステータスを更新
                    $sql_update = "UPDATE t_reservation SET status = '4' WHERE contract_num = :r_num";
                    $statement_update = $dbh->prepare($sql_update);
                    $statement_update->bindParam(':r_num', $r_num);
                    $statement_update->execute();

                    $rowCount = $statement_update->rowCount();

                    if ($rowCount > 0) {
                        $response['success'] = true;
                        $response['message'] = '受付番号' . $r_num.'は予約をチェックアウトしました。';
                    } else {
                        $response['success'] = false;
                        $response['message'] = 'チェックアウトに失敗しました。';
                    }
                }
            } else {
                // t_reserve_noテーブルにその番号があるか確認
                $sql_check_no = "SELECT * FROM t_reserve_no WHERE random_number = :r_num";
                $statement_check_no = $dbh->prepare($sql_check_no);
                $statement_check_no->bindParam(':r_num', $r_num);
                $statement_check_no->execute();

                $reserve_no = $statement_check_no->fetch(PDO::FETCH_ASSOC);

                if ($reserve_no) {

                    if ($reserve_no['status'] == '4') {
                        $response['success'] = true;
                        $response['message'] = 'この受付番号は既に予約を完了しています。';
                    }else{
                        $sql_update = "UPDATE t_reserve_no SET status = '4' WHERE random_number = :r_num";
                        $statement_update = $dbh->prepare($sql_update);
                        $statement_update->bindParam(':r_num', $r_num);
                        $statement_update->execute();
    
                        $rowCount = $statement_update->rowCount();

                        if($rowCount > 0){
                            $response['success'] = true;
                            $response['message'] = '受付番号' . $r_num.'は予約をチェックアウトしました。';  
                        }else{
                            $response['success'] = false;
                            $response['message'] = 'チェックアウトに失敗しました。';
                        }
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = '受付番号 ' . $r_num . ' が見つかりませんでした。もう一度ご確認ください。';
                }
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
