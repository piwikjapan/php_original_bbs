<?php
$wid="";
$wid = $_GET['id'];


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>ID:<?php print($wid); ?> の書込み検索結果</h1>
        <br /><a href="bbs_index.php">掲示板へ戻る</a>
        <hr />
        <?php
            $fp = fopen("bbs_log.txt", "r");  //rで読み込む
            /* 以下ファイルの中身チェック */
            $memotxt = file("bbs_log.txt");   //ファイルの中身を変数へ
            if($memotxt != NULL)
            {
                /* データがあればデータ数分繰り返して表示 */
                while ($line = fgets($fp))  //fgets・・・ファイルから1行分だけテキストを読み込む　その後変数へ代入
                {
                    //IDの検索
                    $sc_kiri = strstr($line, "ID:<a href='search.php?id=".$wid."'>");
                    //IDの部分だけ抜き出す
                    $kiri = mb_substr($sc_kiri, 38,10);
                    //IDが一致する場合のみ表示
                    if($kiri == $wid){
                    print($line);
                    print("<br /><hr />");
                    }
                }
            }
            else
            {
                /* データがないときの文表示 */
                print("<font color='#ff0000'>現在書込み情報がありません。</font><br>");
            }
            fclose($fp);    //ファイルを閉じる
        ?>
    </body>
</html>
