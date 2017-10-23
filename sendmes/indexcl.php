<?php
	class PostMess{
		protected  $ot;
		protected  $do;
		protected  $time;
		protected  $date;
		protected  $mass;
		protected  $message;
		protected  $replacement;
		protected  $messageRez;
		protected  $token ='c46f316f52c076c64c2aea510af611769b1e71dae885a94a45bd922457e6555580d991874f893166bafc3';

		function __construct(){
			require_once('config_PDO.php');
			$this->time = date("H:i:s");
			$this->date = date("d.m.y");
			if(isset($_POST)){
				if((!empty($_POST['ot'])) and (!empty($_POST['do'])) and (!empty($_POST['do']))){
					$this ->ot = $_POST['ot'];
					$this ->do = $_POST['do'];
					$this ->message = $_POST['soob'];
					$this ->message = str_replace(' ',' ', $this ->message);

					$result = $db->prepare("SELECT * FROM user WHERE id_user>=$this->ot and id_user<=$this->do");
					$result->execute();
					while ($row=$result->fetch(PDO::FETCH_ASSOC)){
						$this -> mass[] = array(
							"name" => $row['name'], 
							"vkid" => $row['vk'],
				    		"likes" => $row['likes'],
				    		"vuz" => $row['univer'],
						);
					}
				}
			}
		}

		function sendmes(){
			$this->messageRez = $this->message;
			if(!is_array($this->mass)){
				return null;
			}
				foreach ($this->mass as $mas){
					$this->replacement = array(
						'<имя>' => $mas['name'],
						'<вуз>' => $mas['vuz'],
						'<лайк>' => $mas['likes'],
					);

					sleep(1);
					$this ->message = str_replace(array_keys($this->replacement),array_values($this->replacement), $this ->messageRez);
					$query = file_get_contents("https://api.vk.com/method/messages.send?domain=".urlencode($mas['vkid'])."&message="." ".urlencode($this->message)." "."&access_token=".$this -> token);
					$result1 = json_decode($query,true);
					print_r($result1);
					header('Location: indexcl.php');
				}
				$send = new PostMess();
				$send ->savebase();
		}

		function savebase(){
			include('config_PDO.php');
			$result2 = $db->prepare("INSERT INTO otchet (ot,do,mesage,date,timee) VALUES ('$this->ot','$this->do','$this->message','$this->date','$this->time')");
			$result2->execute();
		}

		function oychet(){
			include('config.php');
			$result2 = $db->prepare("SELECT * FROM otchet ORDER BY id_otchet DESC");
			$result2->execute();
			while ($row=$result2->fetch(PDO::FETCH_ASSOC)){
				echo "<tr>";
					echo "<th>От (id)</th>";
					echo "<th>До (id)</th>";
					echo "<th>Сообщение Рассылки</th> ";
					echo "<th>Дата </th>";
					echo "<th>Время </th>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>".$row['ot']."</td>";
					echo "<td>".$row['do']."</td>";
					echo "<td>".$row['mesage']."</td>";
					echo "<td>".$row['date']."</td>";
					echo "<td>".$row['timee']."</td>";
				echo "</tr>";
			}
		}
	}

	$send = new PostMess();
	$send ->sendmes();
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Оповещение</title>
	<link rel="stylesheet" type="text/css" href="sendstyle.css">
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</head>
<body>
	<div class="otchet">
		<table>
			
		</table>
	</div>
	<form method="post" action="">
		<input type="number" name="do" placeholder="До (id пользователя)" required="">
		<input type="number" name="ot" placeholder="От (id пользователя)" required="">
		
		<textarea cols="50" rows="20" name="soob" placeholder="Пользуйтесь спецмальными конструкциями (<имя> <вуз> <лайк>)" required=""></textarea>
		<br>
		<input type="submit" name="send">
	</form>
</body>
</html>