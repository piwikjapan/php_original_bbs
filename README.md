
# 掲示板について

**Update:2017/01/18**
- 遥か昔、PHPで作成した掲示板です。
- レガシーなコードのメンテナンスはもう恐らく行われません。

## ■この掲示板のファイル構成
- **bbs_index.php** (掲示板ページ)  
掲示板のTOPページです。

- **bbs_log.txt** (掲示板の書き込みログ)  
テキストファイルで書込み情報を管理しています。

- **res_pro.php** (レスボタン処理と削除ボタン処理)  
「このコメントにレスをする」と「削除」ボタンの処理部分です。

- **search.php** (ID検索ページ＆処理)  
掲示板ページにある各ID部分をクリックすると、
そのIDで書き込まれたコメントを検索することができます。

- **write_file.php** (コメント書込み処理)  
コメントを書き込む際に行う処理部分です。
空欄チェックやhtmlspecialcharsによるタグの無効化などここでしております。

## ■この掲示板の機能一覧
- 掲示板への書込み
- txtファイルでの管理
- タグの無効化
- 空白書込みの無効化
- IPアドレスと日付けによる(24時間限定)ID付加機能
- ID検索機能
- URL自動リンク化機能
- レス(返信)機能
- 同一IDのみのコメント削除機能
- AAも表示可能

## データベース化

* 最低限の実装の ＤＤＬ (Data Definition Language: create table で始まるやつ） を掲載しておきます。
  * データベース名 bbs_db、テーブル名 bbs、 UTF8 絵文字対応（utf8mb4）
* seq と created カラムには自動的に値が入ります。
* 他にも消去日時を加えるなどして拡張してください。

```mysql
$ mysql -uroot -ppentester
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 7
Server version: 10.1.41-MariaDB-0ubuntu0.18.04.1 Ubuntu 18.04

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> CREATE DATABASE bbs_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
Query OK, 1 row affected (0.00 sec)

MariaDB [(none)]>  grant all on bbs_db.* to bbs@'localhost' identified by 'bbs_pass' with grant option;
Query OK, 0 rows affected (0.13 sec)

MariaDB [(none)]> exit
Bye
$ mysql -ubbs -pbbs_pass bbs_db
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 8
Server version: 10.1.41-MariaDB-0ubuntu0.18.04.1 Ubuntu 18.04

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [bbs_db]> CREATE TABLE `bbs` (
    ->   `seq` mediumint(9) NOT NULL AUTO_INCREMENT,
    ->   `id` varchar(10) NOT NULL,
    ->   `res` text NOT NULL,
    ->   `created` datetime DEFAULT CURRENT_TIMESTAMP,
    ->   PRIMARY KEY (`seq`),
    ->   key idx_id(`id`)
    -> ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
Query OK, 0 rows affected (0.18 sec)

MariaDB [bbs_db]> INSERT bbs (id, res) VALUES ('aaaaaaaaaa', 'foo'); -- 動作テスト
Query OK, 1 row affected (0.02 sec)

MariaDB [bbs_db]> select * from bbs; -- 動作テスト
+-----+------------+-----+---------------------+
| seq | id         | res | created             |
+-----+------------+-----+---------------------+
|   1 | aaaaaaaaaa | foo | 2019-09-16 16:43:29 |
+-----+------------+-----+---------------------+
1 row in set (0.00 sec)

MariaDB [bbs_db]> exit
```