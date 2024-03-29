<?php
/* ----------------------------------------
 * 必要なファイルを読み込む
 * ---------------------------------------- */
require_once 'private/bootstrap.php';


/* ----------------------------------------
 * セッション開始
 * ---------------------------------------- */

/* ----------------------------------------
 * データベースから投稿されている内容を取得する
 * ---------------------------------------- */
$statement = $dbh->prepare('SELECT * FROM `articles`');
$statement->execute();
$articles = $statement->fetchAll();
?>

<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>掲示板</title>
</head>
<body>
    <header>
        <h1>掲示板</h1>
    </header>
    <main>
        <ul>
            <?php foreach ($articles as $article) { ?>
                <li>
                    <div>
                        <?= $article['id'] ?>:&nbsp;<?= htmlspecialchars($article['name']) ?>&nbsp;作成日:<?= $article['created_at'] ?>、更新日:<?= $article['updated_at'] ?>
                    </div>
                    <div><?=  htmlspecialchars($article['content']) ?></div>
                    <div style="display: inline-flex; ">
                        <form action="editing.php" method="post">
                            <input type="hidden" name="id" value="<?= $article['id'] ?>">
                            <button type="submit">編集</button>
                        </form>
                        &nbsp;
                        <form action="confirm_delete.php" method="post">
                            <input type="hidden" name="id" value="<?= $article['id'] ?>">
                            <button type="submit">削除</button>
                        </form>
                    </div>
                </li>
                <br/>
            <?php } ?>
        </ul>
        <div>
            <form action="confirm.php" method="post">
            <table width=”1000″>
                    <thead>
                    <tr>
                        <th colspan="2">新規投稿</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th><label for="name">名前</label></th>
                        <td><input type="text" name="name" id="name" required></td>
                    </tr>
                    <tr>
                        <th><label for="content">投稿内容</label></th>
                        <td><textarea name="content" id="content" rows="4" required></textarea></td>
                    </tr>
                    </tbody>
                </table>
                <button type="submit">投稿</button>
            </form>
        </div>
    </main>
    <footer>
        <hr>
        <div>(b・ω・)b</div>
    </footer>
</body>
</html>

<?php
/* --------------------
 * Session削除
 * -------------------- */
foreach (array_keys($_SESSION ?? []) as $key) {
    unset($_SESSION[$key]);
}
