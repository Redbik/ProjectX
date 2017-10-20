<?php
	class PostMess{
		public $ot;
		public $do;
		public $time;
		public $date;
		public $mass;
		public $message;
		public $token ='cf974b087e1d336aeb2ff5ed4cb67c0e34faab2be61b97aa7a04574b3a9fb71ee757d3afd239afbdfa1a4';

		function __construct(){
			include('config.php');
			$this->time = date("H:i:s");
			$this->date = date("d.m.y");
			if(isset($_POST)){
				if((empty($_POST['ot'])==false) and (empty($_POST['do'])==false) and (empty($_POST['do'])==false)){
					$this ->ot = $_POST['ot'];
					$this ->do = $_POST['do'];
					$this ->message = $_POST['soob'];
					$this ->message = str_replace(' ',' ', $this ->message);

					$result = $db->prepare("SELECT * FROM post WHERE id_post>=$this->ot and id_post<=$this->do");
					$result->execute();
					while ($row=$result->fetch(PDO::FETCH_ASSOC)){
						$this -> mass[] = array(
							"name" => $row['name'], 
							"vkid" => $row['vk_id'],
				    		"likes" => $row['likes'],
						);
					}
				}
			}
		}

		function sendmes(){
			foreach ($this -> mass as $mas){
				sleep(1);
				$query = file_get_contents("https://api.vk.com/method/messages.send?domain=".urlencode($mas['vkid'])."&message=".urlencode($mas['name'])." ".urlencode($this->message)." ".urlencode($mas['likes'])."&access_token=".$this -> token);
				$result1 = json_decode($query,true);
				// print_r($result1);

			}
			
		}

		function savebase(){
			include('config.php');
			$result2 = $db->prepare("INSERT INTO otchet (ot,do,mesage,date,timee) VALUES ('$this->ot','$this->do','$this->message','$this->date','$this->time')");
			$result2->execute();
		}

		function oychet(){
			include('config.php');
			$result2 = $db->prepare("SELECT * FROM otchet");
			$result2->execute();
			while ($row=$result2->fetch(PDO::FETCH_ASSOC)){
				echo "<table>";
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
				echo "</table>";
			}
		}
	}

	$send = new PostMess();
	$send ->oychet();
	$send ->sendmes();
	$send ->savebase();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Оповещение</title>
</head>
<body>
	<form method="post" action="">
		<input type="number" name="ot" placeholder="От (id пользователя)">
		<input type="number" name="do" placeholder="До (id пользователя)">
		</br></br>
		<textarea cols="50" rows="20" name="soob"></textarea>
		</br></br>
		<input type="submit" name="send">
	</form>
	</br></br>
</body>
</html>