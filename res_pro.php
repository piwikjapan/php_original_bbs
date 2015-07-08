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

            $fp = fopen("bbs_log.txt", "r");  //rで読み込む

            $now = date("Y/m/d H:i");     //現在時刻を変数へ

            //全テキスト読み込み処理
            $no = 1;
            $del_no = 0;
            while (feof($fp)===false)
            {
                $bbs_log[$no] = fgets($fp);
                if($res_no == $no){
                    $bbs_log[$no] = "<strong><a name='no".$no."'>".$no."</a>．削除された書込みさん</strong>　削除時間：".$now."　ID:<a href='search.php?id=**********'>**********</a><br />この書込みはユーザーによって削除されました。\n";
                    $del_no = $no; 
                }
                $no++;
            }


            //logファイルリセット
            $fp = fopen("bbs_log.txt","w");

            $no2 = 1;

            //データ分(行数)だけまわして変数の内容をlog.txtへ書き込む処理
            while ($no2 < $no-1)
            {
                fwrite($fp,$bbs_log[$no2]);
                $no2++;
            }

            fclose($fp);    //ファイルを閉じる
            
            $_SESSION['res'] = "<font color='#ff0000'>あなたの書込み(コメント番号 ".$del_no.")を削除しました。</font>";
            
        }else{
            $_SESSION['res'] = "<font color='#ff0000'>異なるIDの書き込みは削除できません。</font>";
        }
    }
}




header("location: ./bbs_index.php");
exit;

?>
