<?php
session_start();
unset($_SESSION['user_id']);

/* ID生成 */
$userid = substr(md5($_SERVER["REMOTE_ADDR"].date("(Y/m/d)")), 0, 10);
$_SESSION['user_id'] = $userid;

$res_com = $_SESSION['res'];
//初期化
$_SESSION['res'] = "";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>みんなの掲示板</title>
    </head>
    <script type="text/javascript">
    </script>
    <body>
        <h1>みんなの掲示板！</h1>
        <br /><strong>あなたのIDは<a href="search.php?id=<?php print($userid);?>"><?php print($userid);?></a>です。<br />(※日付が変わるとIDも変わります。その場合、前のIDでのコメントが削除できなくなります)</strong>
        <br />
        <form action="write_file.php" method="post"> 
        <br />名前<input type="text" name="name" value="名無しさん＠掲示板">
        <br />コメント
        <br /><textarea name="txt" cols="50" rows="7"><?php print(empty($_SESSION['comment']) ? '' : $_SESSION['comment']) ?></textarea>
        <input type="hidden" name="wid" value="<?php print($userid);?>">
        <br /><input type="submit" value="書き込む！" style="width:130px; height: 30px"> 　　<input type="reset" value="リセットする！" style="width:130px; height: 30px"></form>
    	</form>
        <p><b><?php print($res_com); ?></b></p>
        <hr />
        <h2>みんなの書き込み</h2>
        <?php
            $memotxt = file("bbs_log.txt");   //ファイルの中身を変数へ
            if($memotxt != NULL)
            {
                /* データがあればデータ数分繰り返して表示 */
                foreach ($memotxt as $line)
                {
                    print($line);
                    print("<br /><br />");
                }
            }
            else
            {
                /* データがないときの文表示 */
                print("<font color='#ff0000'>現在書込み情報がありません。</font><br>");
            }
        ?>
    </body>
</html>
