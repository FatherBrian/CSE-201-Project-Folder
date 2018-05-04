<?php
class requests {

	// New Functions
	function generateRequests($connection, $db) { 
		$text = '<div class="container-fluid"><div class="row">';
		$data = $this->getRequestsInfo($connection, $db);
		$text .= $this->displayFriendRequests($data[0]["recieveUserInfo"], $data[0]["sentUserInfo"]);
		$text .= $this->displayGroupConnections($data[0]["sentGroupInfo"]);
		$text .= '</div></div>';
		echo $text;
	}
	
	function getRequestsInfo($connection, $db) {
		$id = $_SESSION['userID'];
		$data = array();
		
		$ids = $db->getRequests($connection, $id);
		$ids = $this->splitRequests($ids);
		if (count($ids[0]["recieveUserIDs"]) != 0) $recieveUserInfo = $db->getUserInfo($connection, $ids[0]["recieveUserIDs"]);
		else $recieveUserInfo = NULL;
		if (count($ids[0]["sentUserIDs"]) != 0) $sentUserInfo = $db->getUserInfo($connection, $ids[0]["sentUserIDs"]);
		else $sentUserInfo = NULL;
		if (count($ids[0]["sentGroupIDs"]) != 0) $sentGroupInfo = $db->getGroupInfo($connection, $ids[0]["sentGroupIDs"]);
		else $sentGroupInfo = NULL;
		$temp = array("recieveUserInfo"=>$recieveUserInfo, "sentUserInfo"=>$sentUserInfo, "sentGroupInfo"=>$sentGroupInfo);
		array_push($data, $temp);
		return $data;
	}		

	function splitRequests($ids) {
		$data = array();
		$recieveUserIDs = array();
		$sentUserIDs = array();
		$sentGroupIDs = array();
		$userID = $_SESSION["userID"];
		foreach($ids as $id) { 
			if ($id["type"] == "recieved" && $id["requesteePartyTypeID"] == 1) { array_push($recieveUserIDs, $id["requesterID"]); }
			else if ($id["type"] == "sent" && $id["requesteePartyTypeID"] == 1 && $id["requesteeID"] != $userID) { array_push($sentUserIDs, $id["requesteeID"]); }
			else if ($id["type"] == "sent" && $id["requesteePartyTypeID"] == 2) { array_push($sentGroupIDs, $id["requesteeID"]); }
		}
		$temp = array("recieveUserIDs"=>$recieveUserIDs, "sentUserIDs"=>$sentUserIDs, "sentGroupIDs"=>$sentGroupIDs);
		array_push($data, $temp);
		return $data;
	}
	
	function displayFriendRequests($recieveUsers, $sentUsers) {
		$text = '<div class="col-xs-6"><h1> Recieved Friends Requests </h1><ul class="requestsList">';
		if ($recieveUsers != NULL) {
			foreach($recieveUsers as $row) {
				$name = $row["fName"] ." ". $row["lName"];
				$text .= '<li><a href="profile.php?id='. $row["id"] .'">'. $name .'</a></li>'; 
			}
		} else { $text .= '<li> No friend requests have been recieved </li>'; }
		$text .='</ul>';
		
		$text .= '<h1> Sent Friend Requests </h1><ul class="requestsList">';
		if ($sentUsers != NULL) {
			foreach($sentUsers as $row) {
				$name = $row["fName"] ." ". $row["lName"];
				$text .= '<li><a href="profile.php?id='. $row["id"] .'">'. $name .'</a></li>'; 
			}
		} else { $text .= '<li> No friend requests have been sent </li>'; }
		$text .='</ul></div>';
		return $text;
	}	

	function displayGroupConnections($groupInfo) {
		$text = '<div class="col-xs-6"><h1> Requested Groups </h1><ul class="requestsList">';
		if ($groupInfo != NULL) {
			foreach($groupInfo as $row) {
				$text .= '<li><a href="group.php?id='. $row["id"] .'">'. $row["name"] .'</a></li>'; 
			}
		} else { $text .= '<li> No group requests have been sent </li>'; }
		$text .='</ul>';
		return $text;
	}

}

?>