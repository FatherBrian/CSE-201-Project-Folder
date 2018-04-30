<?php
class home {

	function generateHomePage($message, $connection, $db, $poster) {
		$text = "";
		if ($message != NULL) { $text .= $message; }
		$text .= '<div class="container-fluid"><div class="row">';
		$data = $this->getPosts($connection, $db, $poster);
		$text .= $this->displayUserGroupPosts($data, $connection, $db);
		$text .= $this->displayUserFriendPosts($data, $connection, $db);
		$text .= '</div></div>';
		echo $text;
	}
	
	function getPosts($connection, $db, $poster) {
		$id = $_SESSION['userID'];
		$data = array();
		
		$ids = $db->getConnections($connection, $id);
		$posts = $poster->getUserPosts($connection, $ids, $id);
		$groups = $poster->getPostedGroups($connection, $posts, $db);
		$users = $poster->getPostingUsers($connection, $posts, $db);
		$temp = array("postArray"=>$posts, "groupArray"=>$groups, "userArray"=>$users);
		array_push($data, $temp);
		return $data;
	}
	
	function displayUserGroupPosts($data, $connection, $db) {
		$text = '<div class="col-xs-6"><h1> Group Posts:</h1>';
		$id = $_SESSION['userID'];		
		foreach($data[0]["postArray"] as $row) {
			if ($row["IDs"]["partyTypeID"] == 2) {
				$groupRow = $db->getIndexRowInfo($data[0]["groupArray"], $row["IDs"]["partyID"], "id");
				$userRow = $db->getIndexRowInfo($data[0]["userArray"], $row["IDs"]["postPartyID"], "id");
				$postFound = True;
				$date = date("M jS Y, H:i a", strtotime($row["Posts"]["tStamp"]));
				$userName = $userRow["fName"]. " " .$userRow["lName"];
				$text .= '<h4 class="postHead"><a href="profile.php?id='. $userRow["id"] .'">'. $userName .'</a>'; 
				$text .= ' posted on <a href="group.php?id='. $groupRow["id"] .'">'. $groupRow["name"] .'</a> at '. $date .'</h4>';
				$text .= '<div class="postBody"><p>'. $row["Posts"]["post"] .'</p></div>';
			}
		}
		if (!$postFound) { $text = '</div><div class="col-xs-6"><h1> No group posts found </h2>'; }
		$text .= '</div>';
		return $text;
	}

	function displayUserFriendPosts($data, $connection, $db) {
		$text = '<div class="col-xs-6"><h1> Friend Posts:</h1>';
		$id = $_SESSION['userID'];
		foreach($data[0]["postArray"] as $row) {
			if ($row["IDs"]["partyTypeID"] == 1) {
				$userRow1 = $db->getIndexRowInfo($data[0]["userArray"], $row["IDs"]["postPartyID"], "id");
				$userRow2 = $db->getIndexRowInfo($data[0]["userArray"], $row["IDs"]["partyID"], "id");
				$postFound = True;
				$date = date("M jS Y, H:i a", strtotime($row["Posts"]["tStamp"]));
				$posterUserName = $userRow1["fName"]. " " .$userRow1["lName"];
				$posteeUserName = $userRow2["fName"]. " " .$userRow2["lName"];
				$text .= '<h4 class="postHead"><a href="profile.php?id='. $userRow1["id"] .'">'. $posterUserName .'</a>'; 
				$text .= ' posted on <a href="profile.php?id='. $userRow2["id"] .'">'. $posteeUserName .'</a> wall at '. $date .':</h4>';
				$text .= '<div class="postBody"><p>'. $row["Posts"]["post"] .'</p></div>';
			}
		}
		if (!$postFound) { $text = '</div><div class="col-xs-6"><h1> No friend posts found </h2>'; }
		$text .= '</div>';
		return $text;
	}
	
}	
?>