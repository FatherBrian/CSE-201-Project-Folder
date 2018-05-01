<?php
class post {
	
	function getUserPosts($connection, $idList, $id) {
		$names = "";
		foreach($idList as $aID) { $names .= "(partyID = '". $aID["partyID"] ."' and partyTypeID = '". $aID["partyTypeID"] ."') or ";	}
		
		if ($names == NULL) $query = "SELECT * FROM post WHERE partyID = ". $id;
        else $query = "SELECT * FROM post WHERE ". substr($names, 0, -4) ." or (partyID = ". $id . " and partyTypeID != 2)";
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

	function getCollegePosts($connection, $id) {
        $query = "SELECT * FROM post WHERE partyID = ". $id ." AND partyTypeID = 3";
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
				// if ($post["IDs"]["partyID"] != $id && $post["IDs"]["partyID"] == 2) {
				if ($post["IDs"]["partyTypeID"] == 2) {
					array_push($groupIDs, $post["IDs"]["partyID"]);
				}
			}
			$groupIDs =array_unique($groupIDs);
			$groupInfo = $db->getGroupInfo($connection, $groupIDs);	
			return($groupInfo);
		}
		return NULL;
	}
	
	function getPostingUsers($connection, $posts, $db, $id) {
		$userIDs = array();
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
	
	function checkIfPost($connection, $type) {
		if(isset($_POST['submit'])) {
			$entry = $_POST['posts'];
			$id = $_GET["id"];
			$postId = $_SESSION["userID"];
			$this->addPost($connection, $entry, $id, $type, $postId);
		}
	}
	
    function addPost($db, $entry, $id, $type, $postId){
	    $time = date('Y-m-d H:i:s');
        $query = "INSERT INTO post (post, tStamp, partyID, partyTypeID, postPartyID) VALUES ('$entry', '$time', '$id', '$type', '$postId')";
        mysqli_query($db, $query);
    }
	
}
?>