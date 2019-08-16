<?php
session_start();
$_SESSION['res'] = "";

//どのボタンかおされたのか判別する
if(isset($_POST['res']) || isset($_POST['del'])){

    $userid = $_SESSION['user_id'];
    $hid_user_id = $_POST['user_id'];
    
    if(isset($_POST['res']) && !isset($_POST['del'])){
        //「レスをする」の処理
        $_SESSION['comment'] .= ">>".$_POST['res_no'];
        
    }else if(isset($_POST['del']) && !isset($_POST['res'])){
        //「削除」の処理
        //ユーザー以外消せないようにする
        if($userid === $hid_user_id){
            $res_no = $_POST['res_no'];
            $lines = file("bbs_log.txt");
            $now = date("Y/m/d H:i");     //現在時刻を変数へ
            foreach ($lines as $pos => $line) {
                if ($res_no == $pos + 1) {
                    $lines[$pos] = "<strong><a name='no" . $pos . "'>" . $res_no . "</a>．削除された書込みさん</strong>　削除時間：" . $now . "　ID:<a href='search.php?id=**********'>**********</a><br />この書込みはユーザーによって削除されました。\n";
                }
            }
            file_put_contents("bbs_log.txt", $lines);
            $_SESSION['res'] = "<font color='#ff0000'>あなたの書込み(コメント番号 ".$res_no.")を削除しました。</font>";
        } else {
            $_SESSION['res'] = "<font color='#ff0000'>異なるIDの書き込みは削除できません。</font>";
        }
    }
}
header("location: ./bbs_index.php");