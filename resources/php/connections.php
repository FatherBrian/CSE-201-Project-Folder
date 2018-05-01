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
		$text .='</ul></div>';
		return $text;		
	}	

}

?>