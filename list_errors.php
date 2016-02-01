<html>
<head>
<script src="http://device4car.ru/lib/jquery.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
echo date("m.d.y")."<br/>";

function colorRow($stNum){
	if ($stNum == "1"){
		echo "<tr bgcolor='#fde910'>";
	}
	else if ($stNum == "2"){
		echo "<tr bgcolor='#138808'>";
	}
	else if ($stNum == "0"){
		echo "<tr>";
	}
}

function printRow($result_set) {
	echo "Количество записей - ".$result_set->num_rows."<br />---------------------------------<br />";
	echo "<table width='100%' border='1'><tr> <td>Номер</td> <td>Суть ошибки</td> <td>Комментарий</td> <td>ФИО</td> <td>e-mail</td> <td>Дата изменения</td> <td>Статус <br />(Новое / В процессе / Готово)</td> </tr>";
		while (($row = $result_set->fetch_assoc()) != false){
			colorRow($row[stat]); //красим строку в зависимости от статуса
				for (reset($row); ($key=key($row)); next($row)) {  //переводим ассоциативный массив в обычный
						if($key=="stat")  //если это статус то рисуем по другому
						{
							$ch="checked='checked'";
							echo "<td>";
							for ($i=0; $i<3; $i++)
							{
								if ($i==$row[$key]){
									echo "<input type='radio' name='stat".$row[id]."' id='".$row[id]."' value=".$i." checked='checked'>";
								}else{
									echo "<input type='radio' name='stat".$row[id]."' id='".$row[id]."' value=".$i.">";
								}
								
							}
							echo "</td>";
						}else{
							echo "<td>".$row[$key]."</td>";	//отрисовывываем ячейки
						}

					}
					echo "</tr>";
		}
		echo "</table>";

	}
$mysqli = new mysqli('localhost', 'owen', '1745054', 'nvbposyan1450ru1724_errorReports');
$mysqli->query ("SET NAMES 'utf8'");
$result_set = $mysqli -> query("SELECT * FROM `errors` ORDER BY id DESC");
printRow($result_set);
$mysqli->close();

?>
<script>
	$(document).ready(function(){
		$('input').change(function(){
			var radioID=$(this).attr('id');
			var radioVal=$(this).val();
			console.log(report_data);


	var report_data="statVal="+radioVal+"&statID="+radioID;
	console.log(report_data);

		$.ajax({
			url:"http://device4car.ru/php/report_errors.php",
			data: report_data,
			type: "POST",
	success: function(respond){
				location.reload();
			},
	error: function(){
				alert('ошибка')
			}
		})

		})
	})
</script>
</head>