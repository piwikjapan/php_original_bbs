<?php
session_start();
//初期化
$_SESSION['res']="";


$userid = $_SESSION['user_id'];

$fp = fopen("bbs_log.txt", "r");  //rで読み込む
for($count = 1; fgets( $fp ); $count++);


/* htmlspecialcharsでタグを無効化した後、変数へ代入 */
$username = htmlspecialchars($_POST['name']);
$memo = htmlspecialchars($_POST['txt']);    //txtファイルに一行で書き込む処理

//空書込みを防ぐ処理
if($username === ""){
    $_SESSION['res'] = "<font color='#ff0000'>名前を入力してください。</font>";
    header("location: ./bbs_index.php");
    exit;
}elseif ($memo === "") {
    $_SESSION['res'] = "<font color='#ff0000'>コメントを入力してください。</font>";
    header("location: ./bbs_index.php");
    exit;    
}

$repmemo = str_replace(array("\r\n","\n","\r"),"<br />",$memo); //改行をタグへ変換
$repmemo = preg_replace('/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', '<A href="\\1\\2">\\1\\2</A>', $repmemo); //URLをリンクへ変換
$repmemo = preg_replace('/(&gt;&gt;([0-9]*))/','<a href="#no$2">$1</a>',$repmemo);   //アンカーをリンク付きに変換

$wid = htmlspecialchars($_POST['wid']); //ID
$now = date("(Y/m/d H:i)");     //現在時刻を変数へ
if (file_put_contents("bbs_log.txt",
    "<form action='res_pro.php' method='post'><strong><a name='no".$count."'>".$count."</a>．".$username."</strong> ".$now."　ID:<a href='search.php?id=".$wid."'>".$wid."</a>　<input type='submit' name='res' value='このコメントにレスする'>　<input type='submit' name='del' value='削除'>　<input type='hidden' name='res_no' value='".$count."'><input type='hidden' name='user_id' value='".$userid."'></form>".$repmemo.PHP_EOL,
    FILE_APPEND
) === false) {
    $_SESSION['res'] = "<font color='#ff0000'>エラー：コメントの書き込みに失敗しました。</font>";
} else {
    $_SESSION['res'] = "コメントを書き込みました。";
}
$_SESSION['comment'] = "";

header("location: ./bbs_index.php");
