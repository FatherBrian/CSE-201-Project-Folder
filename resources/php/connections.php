<?php
class connections {

	// New Functions
	function generateConnections($connection, $db) { 
		$text = '<div class="container-fluid"><div class="row">';
		$data = $this->getConnectionsInfo($connection, $db);
		$text .= $this->displayGroupConnections($data[0]["groupInfo"]);
		$text .= $this->displayUserConnections($data[0]["userInfo"]);
		$text .= '</div></div>';
		echo $text;
	}
	
	function getConnectionsInfo($connection, $db) {
		$id = $_SESSION['userID'];
		$data = array();
		
		$ids = $db->getConnections($connection, $id);
		$ids = $this->splitConnections($ids);
		$groupInfo = $db->getGroupInfo($connection, $ids[0]["groupIDs"]);
		$userInfo = $db->getUserInfo($connection, $ids[0]["userIDs"]);
		$temp = array("groupInfo"=>$groupInfo, "userInfo"=>$userInfo);
		array_push($data, $temp);
		return $data;
	}		

	function splitConnections($ids) {
		$data = array();
		$groupIDs = array();
		$userIDs = array();
		foreach($ids as $id) { 
			if ($id["partyTypeID"] == 1) { array_push($userIDs, $id["partyID"]); }
			else if ($id["partyTypeID"] == 2) { array_push($groupIDs, $id["partyID"]); }
		}
		$temp = array("groupIDs"=>$groupIDs, "userIDs"=>$userIDs);
		array_push($data, $temp);
		return $data;
	}
	
	function displayGroupConnections($groupInfo) {
		$text = '<div class="col-xs-6"><h1> Groups </h1><ul class="connectionsList">';
		if ($groupInfo != NULL) {
			foreach($groupInfo as $row) {
				$text .= '<li><a href="group.php?id='. $row["id"] .'">'. $row["name"] .'</a></li>'; 
			}
		} else { $text .= '<li> No groups have been followed </li>'; }
		$text .='</ul></div>';
		return $text;
	}	

	function displayUserConnections($userInfo) {
		$text = '<div class="col-xs-6"><h1> Friends </h1><ul class="connectionsList">';
		if ($userInfo != NULL) {
			foreach($userInfo as $row) {
				$name = $row["fName"] ." ". $row["lName"];
				$text .= '<li><a href="profile.php?id='. $row["id"] .'">'. $name .'</a></li>'; 
			}
		} else { $text .= '<li> No friends have been added </li>'; }
		$text .='</ul>';
		if ($userInfo != NULL) $text .= $this->makeMessage($userInfo);
		return $text;		
	}
	
	function makeMessage($userInfo) {
		$text = '<div class="col-xs-6"><h1> Send Message </h1>';
        $text .= ' <div class="makeMessage">
                  <form action="connections.php?action=sendMessage" style="padding-top:20px;" method="post">
				  Send To: <select name="recieveID">'. $this->makeOptions($userInfo) .'</select>
				  <textarea style="margin-top:20px;" id="message" name="message"></textarea>
				  <input class="buttonDesign1 uploadImg" style="display:block;" type="submit" name="submit" value="Send Message">
				  </form></div></div>';
        return $text;		
	}
	
	function makeOptions($userInfo) {
		$text = '';
		foreach($userInfo as $row) {
			$name = $row["fName"] ." ". $row["lName"];
			$text .= '<option value="'. $row["id"] .'">'. $name . '</option>'; 
		}
		return $text;
	}		
	
	function processMessages($connection) {
		if (isset($_GET['action'])) { $action = $_GET['action']; } 
		else { $action = "none"; }
		
		if ($action == 'sendMessage') { $this->sendMessage($connection, $_FILES); }
	}
	
	function sendMessage($connection) {
		$message = $_POST['message'];
		$sendID = $_SESSION['userID'];
		$recieveID = $_POST['recieveID'];
	    $time = date('Y-m-d H:i:s');		
        $query = "INSERT INTO message (message, tStamp, sendID, recieveID) VALUES ('$message', '$time', '$sendID', '$recieveID')";
        mysqli_query($connection, $query);
		
	}

}

?>