<?php

try {
    //
    $dsn = "mysql:dbname=ih4c;host=127.0.0.1;charset=utf8mb4";
    $option = [
        // 静的プレースホルダを指定
        PDO::ATTR_EMULATE_PREPARES => false,
        // 複文実行を禁止
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    //
    //dbhとはデータベース ハンドルの略
    $dbh = new PDO($dsn, 'root', '', $option);
} catch (PDOException $e) {

    echo $e->getMessage();
    exit; 
}


?>