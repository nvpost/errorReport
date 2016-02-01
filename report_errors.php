<?php




//отправляем ошибку в базу

	$mysqli = new mysqli('localhost', 'owen', '1745054', 'nvbposyan1450ru1724_errorReports');
	$nd=date("m.d.y");
	$mysqli->query ("SET NAMES 'utf8'");

	if(($_POST['statID'])){  //проверяем чтоже нам пришло
		$statVal = $_POST['statVal'];
		$statID = $_POST['statID'];
		$mysqli->query("UPDATE `errors` SET `stat`='".$statVal."' WHERE ID='".$statID."'");		
	} else 
		{
			$er_sbj = $_POST['er_sbj'];
			$mess = $_POST['mess'];
			$mail=$_POST['email'];
			$fio=$_POST['fio'];
			$header = 'FROM: error_reports@owen.ru' ."\r\n". 'Reply-To: webmaster@example.com'. "\r\n";
			$msg="Сообщение от: ".$mail." ошибка: ".$er_sbj.". Коментарий ". $mess. ", от кого: ".$fio;
		$mysqli->query("INSERT INTO `errors` (`err`, `comment`, `fio`, `email`) VALUES('".$er_sbj."', '".$mess."', '".$fio."', '".$mail."')");	
		mail("nvbpost@yandex.ru", 'Сообщение об ошибке с сайта ОВЕН', $msg, $header); 
		echo 'сообщене отправлено '. $mail.' Спасибо '.$fio;	
		}


	$mysqli->close();

?>