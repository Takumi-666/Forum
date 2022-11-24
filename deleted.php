<?php
/* --------------------------------------------------
 * 必要なファイルを読み込む
 * -------------------------------------------------- */
require_once 'private/bootstrap.php';
require_once 'private/database.php';

/** @var PDO $dbh データベースハンドラ */
/* --------------------------------------------------
 * 送られてきた値を取得する
 * -------------------------------------------------- */
session_start();
$token = $_POST['token'];
// $name = $_POST['name'];
// $content = $_POST['content'];

/* --------------------------------------------------
 * 送られてきたトークンのバリデーション + 値のバリデーション
 *
 * セッションに保存されているトークンと比較し、
 * 一致していなかった場合はトップ画面にリダイレクトする
 * -------------------------------------------------- */
//  var_dump($token);
//  var_dump($_SESSION['token']);
//  exit();
 
if($token !== $_SESSION['token'] ){
    unset($_SESSION['token']);
    redirect('/index.php');
}

/* --------------------------------------------------
 * セッション内に保存したIDを取得する
 * -------------------------------------------------- */
$id = $_SESSION['id'];

/* --------------------------------------------------
 * データの更新処理
 * -------------------------------------------------- */
$sql = "DELETE FROM `articles` WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->execute(['id' => $id]);


/* --------------------------------------------------
 * セッション内のデータを削除する
 * -------------------------------------------------- */
unset($_SESSION['token']);
unset($_SESSION['id']);

?>

<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>削除成功</title>
</head>
<body>
    <header>
        <h1>削除成功</h1>
    </header>
    <main>
        <a href="index.php">戻る</a>
    </main>
    <footer>
        <hr>
        <div>(　・ω・)ノ</div>
    </footer>
</body>
</html>
