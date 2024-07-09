<?php

try{

    require('db/dbpdo.php');
    $userID = isset($_GET['userID']);
    if($userID != NULL){
        $chatid = $_GET['userID'];
        }else{
            $chatid = 2;
        }
    
    $sql = ("SELECT * FROM `t_chat` WHERE `player` = '".$chatid."' OR `c_Partner` = '".$chatid."' ORDER BY CAST(`time` AS TIME) ASC"); 
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $chat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

    $sql = ("SELECT * FROM `t_user` where u_Id != '1'"); 
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);




    // $sql = ("SELECT * FROM t_testuser WHERE MOD(player, 2) = 0"); 
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute();
    // $driver = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }catch (PDOException $e) {
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Example</title>
    <link rel="stylesheet" href="css/chat.css">
</head>
<body>

    <nav class="header">
        <a href="index.php">戻る</a>
    </nav>

    <main>
        <div class="driverselect">
            <?php 
            //ドライバー選択
            foreach($user as $item):?>
            <div>
                <?php $user = $item['u_Id']; ?>
                <a href="chat.php?userID=<?php echo $user; ?>" class="button">
                    <h4><?php echo($item['u_Name']); ?></h4>
                    <p>最新のチャット入れたいね♡</p>
                </a>
            </div>
        <?php
            endforeach;
            ?>
        </div>
        
        <div class="chat-container">
            <div class="chcon" id="chatContent">
                <?php
                //chat表示
                foreach ($chat as $item): ?>
                <?php if($item['player'] == 1){?>
                <div class="base">
                    <div class="message-content">
                        <?php echo $item['text'];?>
                    </div>
                </div>
                <?php
                } else{?>
                <div class="driver">
                    <div class="message-content">
                        <?php echo $item['text']; ?>
                    </div>
                </div>
                <?php }?>
                <?php endforeach;?>
            </div>
            <div class="form">
                <form method="post" action="db/text.php">
                    <input type="text" value="<?php echo $chatid; ?>" name="test"  hidden>
                    <input type="text" name="text" placeholder="Type your message here">
                    <input type="image" src="images/22633428.png" alt="send" class="sendimg" value="">
                </form>
            </div>
        </div>
    </main>
</body>
</html>
