<?php
class post {
	
	function getUserPosts($connection, $idList, $id) {
		$names = "";
		foreach($idList as $aID) { $names .= "(partyID = '". $aID["partyID"] ."' and partyTypeID = '". $aID["partyTypeID"] ."') or ";	}
		
        $query = "SELECT * FROM post WHERE ". substr($names, 0, -4) ." or partyID = ". $id;
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
	
	function getGroupPosts($connection, $id) {
        $query = "SELECT * FROM post WHERE partyID = ". $id ." AND partyTypeID = 2";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
			$posts = array();
            while ($row = mysqli_fetch_assoc($result)) {
				$temp = array("post"=>$row["post"], "tStamp"=>$row["tStamp"]);
				$temp2 = array("partyID"=>$row["partyID"], "partyTypeID"=>$row["partyTypeID"], "postPartyID"=>$row["postPartyID"]);
				$temp3 = array("Posts"=>$temp, "IDs"=>$temp2);
				array_push($posts, $temp3);
			}
		} else { $posts = NULL; }
		return $posts;
	}
	
	function getPostedGroups($connection, $posts, $db) {
		$groupIDs = array();
		$id = $_SESSION['userID'];
		if ($posts != NULL) {
			foreach($posts as $post) {
				if ($post["IDs"]["partyID"] != $id and $post["IDs"]["partyID"] == 2) {
					array_push($groupIDs, $post["IDs"]["partyID"]);
				}
			}
			$groupIDs =array_unique($groupIDs);
			$groupInfo = $db->getGroupInfo($connection, $groupIDs);	
			// print_r($groupIDs);
			return($groupInfo);
		}
		return NULL;
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

     function getPostSystem($type) {
        $text = ' <div class="makePost">
                  <form action="'. $type .'.php?id=' . $_GET['id'] . '" style="padding-top:20px;" method="post">
				  <textarea id="posts" name="posts"></textarea>
				  <input type="submit" name="submit" value="Post Status">
				  </form></div></div>';
        return $text;
    }
	
}
?>