<html>
 <head>
	<meta charset = "utf=8">
	<title>mission_4-1</title>
 </head>

<?php

//データベース接続
$dsn = 'データベース'; 
$user = 'ユーザー名'; 
$password = 'パスワード'; 
$pdo = new PDO($dsn, $user, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
$sql = "CREATE TABLE IF NOT EXISTS tbtest8" 
." (" 
. "id INT," 
. "name char(32)," 
. "comment TEXT," 
. "pass TEXT"
.");";
$stmt = $pdo->query($sql);
$cnt = $pdo -> prepare("SELECT COUNT(*)FROM tbtest8");
$cnt -> execute();
$count = ($cnt->fetchColumn()+1);

//削除機能
if(!empty($_POST["Sakujo"]) and !empty($_POST["Pass2"]) and !empty($_POST["Delete"])){//もし削除番号が送信されたら
	//Pass2とSakujo番号が正しいペアか調べる
	$id = $_POST["Sakujo"];//$idに削除対象番号を入れる
	$pass = $_POST["Pass2"];
	$sql = 'SELECT*FROM tbtest8 ORDER BY id';//order by は並べますよ
//	$stmt = $pdo->prepare($sql);
//	$stmt -> bindParam(':id',$id,PDO::PARAM_INT);
//	$stmt -> bindParam(':pass',$pass, PDO::PARAM_STR);
	$results = $pdo->query($sql);//queryはMySQL(データベース上)で実行しますよ
	foreach ($results as $row){
		if($row['id']==$_POST["Sakujo"] and $row['pass']==$_POST["Pass2"]){//idとSakujoが一緒　且つ　passとPass2が一緒なら
			$sql = 'delete from tbtest8 where id=:id';//デリートの場所指定
			$stmt = $pdo->prepare($sql);//sql準備
			$stmt -> bindParam(':id',$id, PDO::PARAM_INT);//bindParamで番号カラム指定、
			$stmt->execute();//execute
		}
	}
}

//編集機能
if(!empty($_POST["Hensyu"]) and !empty($_POST["Pass3"]) and !empty($_POST["Edit"])){//編集対象番号に数字が入っていてパスワードが入力されてる時
	$id = $_POST["Hensyu"];
	$pass = $_POST["PAss3"];
	$sql = 'SELECT*FROM tbtest8 ORDER BY id';//$_POST["Hensyu"]と同じ番号のid列を抜き出す
//	$stmt = $pdo->prepare($sql); 
//	$stmt -> bindParam(':id', $id, PDO::PARAM_STR);
//	$stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
//	$stmt -> execute();
	$results = $pdo->query($sql);//配列にする（phpでいうfile関数） 
	foreach ($results as $row){
		if($row['id']==$_POST["Hensyu"] and $row['pass']==$_POST["Pass3"]){//番号一致　且つ　パス一致
			$postname = $row['name'];//Value変数に各カラムが記入される
			$postcomment = $row['comment'];
			$postpass1 = $row['pass'];
			$postkakusu = $row['id'];
		}
	}
 }
//編集して書き直す
if(!empty($_POST["Name"]) and !empty($_POST["Comment"]) and !empty($_POST["Pass1"]) and !empty($_POST["Kakusu"]) and !empty($_POST["Sousin"])){//Kakusuに編集対象番号が入っている時
	$sql = 'SELECT*FROM tbtest8 ORDER BY id';
	$results = $pdo->query($sql);
//	foreach($results as $row){
		$id = $_POST["Kakusu"];  
		$name = $_POST["Name"]; 
		$comment = $_POST["Comment"];
		$pass = $_POST["Pass1"];
//		if($row['id']==$_POST["Kakusu"] and $row['pass']==$_POST["Pass1"]){//hiddenとidが一致　且つpass１とpassが一致
			$sql = "update tbtest8 set name='$name',comment='$comment', pass='$pass' where id=$id";//""は変数を含む
//			$stmt = $pdo -> prepare($sql); 
//			$stmt -> bindParam(':name', $name, PDO::PARAM_STR); 
//			$stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
//			$stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
//			$stmt -> execute();
			$result = $pdo->query($sql);
//			}
//		}
	}

//テーブルにデータを代入
if(!empty($_POST["Name"]) and !empty($_POST["Comment"]) and !empty($_POST["Sousin"]) and empty($_POST["Kakusu"]) and !empty($_POST{"Sousin"})){//もし名前とコメントと送信がemptyでないなら
	$sql = $pdo -> prepare("INSERT INTO tbtest8 (id,name, comment,pass) VALUES (:id, :name, :comment, :pass)"); //prepare：名前とコメントのカラムを挿し込む
	$sql -> bindParam(':id',$id,PDO::PARAM_INT);
	$sql -> bindParam(':name', $name, PDO::PARAM_STR); //bindParam：名前カラムを＄表記に 
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);//bindParam：コメントカラムを＄表記に
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$id = $count;
	$name = $_POST["Name"];//$表記に送信された名前を代入
	$comment = $_POST["Comment"];//$表記に送信されたコメントを代入
	$pass = $_POST["Pass1"];
	$sql -> execute();
	}
?>


 <body>
	<form action = "mission_4.php" method = "POST">

	<input type = "text" name = "Name" Placeholder = "名前" Value = "<?php echo $postname ?>"><br>
	<input type = "text" name = "Comment" Placeholder ="コメント" Value = "<?php echo $postcomment ?>"><br>
	<input type = "text" name = "Pass1" Placeholder = "パスワード" Value = "<?php echo $postpass1 ?>"><br>

	<input type = "hidden" name = "Kakusu" Value = "<?php echo $postkakusu ?>">

	<input type = "submit" name = "Sousin" Value = "送信"><br><br>

	<input type = "text" name = "Sakujo" Placeholder = "削除対象番号"><br>
	<input type = "text" name = "Pass2" Placeholder = "パスワード"><br>

	<input type = "submit" name = "Delete" Value = "削除"><br><br>

	<input type = "text" name = "Hensyu" Placeholder = "編集対象番号"><br>
	<input type = "text" name = "Pass3" Placeholder = "パスワード"><br>

	<input type = "submit" name = "Edit" Value = "編集"><br>

<?php
//入力されたデータをselectによって表示
$sql = 'SELECT * FROM tbtest8'; 
$stmt = $pdo->query($sql); 
$results = $stmt->fetchAll(); 
foreach ($results as $row){    
	echo $row['id'].',';
	echo $row['name'].',';    
	echo $row['comment'].'<br>'; 
	}

?>
 </body>

</html>