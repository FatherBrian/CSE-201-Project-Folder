<?php

class message {

	function generateMessages($connection, $db) {
		$id = $_SESSION['userID'];
		$messages = $db->getMessages($connection, $id);
		$text = $this->displayMessages($messages[0], $connection, $db);
		echo $text;
	}

	function displayMessages($data, $connection, $db) {
		$id = $_SESSION["userID"];
		$users = $db->getUserInfo($connection, $data["sendIDs"]);
		$text = '<div class="col-xs-12"><h1>Messages </h1>';
		if ($data["messages"] != NULL) {
			foreach($data["messages"] as $row) {
				$userRow = $db->getIndexRowInfo($users, $row["sendID"], "id");
				$date = date("M jS Y, H:i a", strtotime($row["tStamp"]));
				$posterUserName = $userRow["fName"]. " " .$userRow["lName"];
				$text .= '<h4 class="postHead"><a href="profile.php?id='. $userRow["id"] .'">'. $posterUserName .'</a>'; 
				$text .= ' sent a message at '. $date .':</h4>';
				$text .= '<div class="postBody"><p>'. $row["message"] .'</p></div>';
			}
		} else { $text = '<div class="col-xs-12"><h1> No messages were found </h1>'; }
		return $text;
	}	
}

?>