<?php
class home {

	function generateHomePage($message, $connection, $db) {
		$text = "";
		if ($message != NULL) { $text .= $message; }
		$text .= '<div class="container-fluid"><div class="row"><div class="col-xs-6">';
		$data = $this->getPosts($connection, $db);
		$text .= $this->displayUserGroupPosts($data, $connection, $db);
		$text .= $this->displayUserFriendPosts($data, $connection, $db);
		// $text .= '</div></div>';
		// echo $text;
	}
	
	function getPosts($connection, $db) {
		$data = array();
		$ids = $db->getConnections($connection);
		$posts = $this->getUserPosts($connection, $ids);
		$groups = $this->getPostedGroups($connection, $posts, $db);
		$users = $this->getPostingUsers($connection, $posts, $db);
		$temp = array("postArray"=>$posts, "groupArray"=>$groups, "userArray"=>$users);
		array_push($data, $temp);
		return $data;
	}

	function getUserPosts($connection, $idList) {
		$names = "";
		foreach($idList as $id) { $names .= "(partyID = '". $id["partyID"] ."' and partyTypeID = '". $id["partyTypeID"] ."') or ";	}
	
		$id = $_SESSION['userID'];
        $query = "SELECT * FROM post WHERE ". substr($names, 0, -4) ." or partyID = ". $id;
		// echo $query;
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
			$posts = array();
            while ($row = mysqli_fetch_assoc($result)) {
				$temp = array("post"=>$row["post"], "tStamp"=>$row["tStamp"]);
				$temp2 = array("partyID"=>$row["partyID"], "partyTypeID"=>$row["partyTypeID"], "postPartyID"=>$row["postPartyID"]);
				$temp3 = array("Posts"=>$temp, "IDs"=>$temp2);
				array_push($posts, $temp3);
			}
		} else { $data = NULL; }
		return $posts;
	}
	
	function getPostedGroups($connection, $posts, $db) {
		$groupIDs = array();
		$id = $_SESSION['userID'];		
		foreach($posts as $post) {
			if ($post["IDs"]["partyID"] != $id and $post["IDs"]["partyID"] == 2) {
				array_push($groupIDs, $post["IDs"]["partyID"]);
			}
		}
		$groupIDs =array_unique($groupIDs);
		// print_r($groupIDs);
		$groupInfo = $db->getGroupInfo($connection, $groupIDs);	
		return($groupInfo);
	}
	
	function getPostingUsers($connection, $posts, $db) {
		$userIDs = array();
		$id = $_SESSION['userID'];		
		foreach($posts as $post) {
			array_push($userIDs, $post["IDs"]["postPartyID"]);
		}
		array_push($userIDs, $id);
		$userIDs =array_unique($userIDs);
		$userInfo = $db->getUserInfo($connection, $userIDs);	
		return $userInfo;
		
	}
	
	function displayUserGroupPosts($data, $connection, $db) {
		$text = '</div><div class="col-xs-6"><h1> Group Posts:</h1>';
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
		echo $text;
		return $text;
	}

	function displayUserFriendPosts($data, $connection, $db) {
		$text = '</div><div class="col-xs-6"><h1> Friend Posts:</h1>';
		$id = $_SESSION['userID'];
		foreach($data[0]["postArray"] as $row) {
			if ($row["IDs"]["partyTypeID"] == 1) {
				// print_r($data[0]["userArray"]);
				// print_r($row);
				$userRow1 = $db->getIndexRowInfo($data[0]["userArray"], $row["IDs"]["postPartyID"], "id");
				$userRow2 = $db->getIndexRowInfo($data[0]["userArray"], $row["IDs"]["partyID"], "id");
				// print_r($data[0]);
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
		echo "<br><br><br>". $text;
		return $text;
	}
	
}	
?>