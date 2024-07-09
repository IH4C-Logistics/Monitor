<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>トップ</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="header">
        <p>A物流拠点</p>
        <a href="chat.php">chat</a>
        <a class="login_window">ログイン</a>
    </nav>

    <div class="modal"></div>
    <div class="login_modal">
    <h2>ログイン</h2>
        <form id="login_form">
            <label for="baseid">物流拠点ID</label>
            <input type="text" id="baseid" name="baseid" required>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">ログイン</button>
        </form>
    </div>

    <div class="container">
        <a href="loading.php">
            <div class="button">
                積込状況管理
            </div>
        </a>
        <a href="reservation.php">
            <div class="button">
                予約状況管理
            </div>
        </a>
    </div>
    
<script>
    $(document).on('click', '.login_window', function() {
        // 背景をスクロールできないように & スクロール場所を維持
        scroll_position = $(window).scrollTop();
        $('body').addClass('fixed').css({ 'top': -scroll_position });
        // モーダルウィンドウを開く
        $('.login_modal').fadeIn();
        $('.modal').fadeIn();
    });

    $(document).on('click', '.modal', function() {
        // 背景スクロールを再開し、モーダルを閉じる
        $('body').removeClass('fixed').css({ 'top': '' });
        $(window).scrollTop(scroll_position);
        $('.login_modal').fadeOut();
        $('.modal').fadeOut();
    });
</script>
</body>
</html>
