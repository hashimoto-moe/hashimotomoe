<html>
 <head>
	<meta charset = "utf=8">
	<title>mission_4-1</title>
 </head>

<?php

//�f�[�^�x�[�X�ڑ�
$dsn = '�f�[�^�x�[�X'; 
$user = '���[�U�[��'; 
$password = '�p�X���[�h'; 
$pdo = new PDO($dsn, $user, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//�e�[�u���쐬
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

//�폜�@�\
if(!empty($_POST["Sakujo"]) and !empty($_POST["Pass2"]) and !empty($_POST["Delete"])){//�����폜�ԍ������M���ꂽ��
	//Pass2��Sakujo�ԍ����������y�A�����ׂ�
	$id = $_POST["Sakujo"];//$id�ɍ폜�Ώ۔ԍ�������
	$pass = $_POST["Pass2"];
	$sql = 'SELECT*FROM tbtest8 ORDER BY id';//order by �͕��ׂ܂���
//	$stmt = $pdo->prepare($sql);
//	$stmt -> bindParam(':id',$id,PDO::PARAM_INT);
//	$stmt -> bindParam(':pass',$pass, PDO::PARAM_STR);
	$results = $pdo->query($sql);//query��MySQL(�f�[�^�x�[�X��)�Ŏ��s���܂���
	foreach ($results as $row){
		if($row['id']==$_POST["Sakujo"] and $row['pass']==$_POST["Pass2"]){//id��Sakujo���ꏏ�@���@pass��Pass2���ꏏ�Ȃ�
			$sql = 'delete from tbtest8 where id=:id';//�f���[�g�̏ꏊ�w��
			$stmt = $pdo->prepare($sql);//sql����
			$stmt -> bindParam(':id',$id, PDO::PARAM_INT);//bindParam�Ŕԍ��J�����w��A
			$stmt->execute();//execute
		}
	}
}

//�ҏW�@�\
if(!empty($_POST["Hensyu"]) and !empty($_POST["Pass3"]) and !empty($_POST["Edit"])){//�ҏW�Ώ۔ԍ��ɐ����������Ă��ăp�X���[�h�����͂���Ă鎞
	$id = $_POST["Hensyu"];
	$pass = $_POST["PAss3"];
	$sql = 'SELECT*FROM tbtest8 ORDER BY id';//$_POST["Hensyu"]�Ɠ����ԍ���id��𔲂��o��
//	$stmt = $pdo->prepare($sql); 
//	$stmt -> bindParam(':id', $id, PDO::PARAM_STR);
//	$stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
//	$stmt -> execute();
	$results = $pdo->query($sql);//�z��ɂ���iphp�ł���file�֐��j 
	foreach ($results as $row){
		if($row['id']==$_POST["Hensyu"] and $row['pass']==$_POST["Pass3"]){//�ԍ���v�@���@�p�X��v
			$postname = $row['name'];//Value�ϐ��Ɋe�J�������L�������
			$postcomment = $row['comment'];
			$postpass1 = $row['pass'];
			$postkakusu = $row['id'];
		}
	}
 }
//�ҏW���ď�������
if(!empty($_POST["Name"]) and !empty($_POST["Comment"]) and !empty($_POST["Pass1"]) and !empty($_POST["Kakusu"]) and !empty($_POST["Sousin"])){//Kakusu�ɕҏW�Ώ۔ԍ��������Ă��鎞
	$sql = 'SELECT*FROM tbtest8 ORDER BY id';
	$results = $pdo->query($sql);
//	foreach($results as $row){
		$id = $_POST["Kakusu"];  
		$name = $_POST["Name"]; 
		$comment = $_POST["Comment"];
		$pass = $_POST["Pass1"];
//		if($row['id']==$_POST["Kakusu"] and $row['pass']==$_POST["Pass1"]){//hidden��id����v�@����pass�P��pass����v
			$sql = "update tbtest8 set name='$name',comment='$comment', pass='$pass' where id=$id";//""�͕ϐ����܂�
//			$stmt = $pdo -> prepare($sql); 
//			$stmt -> bindParam(':name', $name, PDO::PARAM_STR); 
//			$stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
//			$stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
//			$stmt -> execute();
			$result = $pdo->query($sql);
//			}
//		}
	}

//�e�[�u���Ƀf�[�^����
if(!empty($_POST["Name"]) and !empty($_POST["Comment"]) and !empty($_POST["Sousin"]) and empty($_POST["Kakusu"]) and !empty($_POST{"Sousin"})){//�������O�ƃR�����g�Ƒ��M��empty�łȂ��Ȃ�
	$sql = $pdo -> prepare("INSERT INTO tbtest8 (id,name, comment,pass) VALUES (:id, :name, :comment, :pass)"); //prepare�F���O�ƃR�����g�̃J������}������
	$sql -> bindParam(':id',$id,PDO::PARAM_INT);
	$sql -> bindParam(':name', $name, PDO::PARAM_STR); //bindParam�F���O�J���������\�L�� 
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);//bindParam�F�R�����g�J���������\�L��
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$id = $count;
	$name = $_POST["Name"];//$�\�L�ɑ��M���ꂽ���O����
	$comment = $_POST["Comment"];//$�\�L�ɑ��M���ꂽ�R�����g����
	$pass = $_POST["Pass1"];
	$sql -> execute();
	}
?>


 <body>
	<form action = "mission_4.php" method = "POST">

	<input type = "text" name = "Name" Placeholder = "���O" Value = "<?php echo $postname ?>"><br>
	<input type = "text" name = "Comment" Placeholder ="�R�����g" Value = "<?php echo $postcomment ?>"><br>
	<input type = "text" name = "Pass1" Placeholder = "�p�X���[�h" Value = "<?php echo $postpass1 ?>"><br>

	<input type = "hidden" name = "Kakusu" Value = "<?php echo $postkakusu ?>">

	<input type = "submit" name = "Sousin" Value = "���M"><br><br>

	<input type = "text" name = "Sakujo" Placeholder = "�폜�Ώ۔ԍ�"><br>
	<input type = "text" name = "Pass2" Placeholder = "�p�X���[�h"><br>

	<input type = "submit" name = "Delete" Value = "�폜"><br><br>

	<input type = "text" name = "Hensyu" Placeholder = "�ҏW�Ώ۔ԍ�"><br>
	<input type = "text" name = "Pass3" Placeholder = "�p�X���[�h"><br>

	<input type = "submit" name = "Edit" Value = "�ҏW"><br>

<?php
//���͂��ꂽ�f�[�^��select�ɂ���ĕ\��
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