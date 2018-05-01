<?php
class profile
{

	// New Functions
	function generateProfilePage($connection, $db, $poster, $page) { 
		$text = '<div class="container-fluid"><div class="row">';
		$text .= $this->generateProfile($connection, $db, $page);
		$data = $this->getPosts($connection, $db, $poster);
		if ($data != NULL) $text .= $this->displayUserFriendPosts($data, $connection, $db);
		else $text .= '<div class="col-xs-6"><h1> No friend posts found </h2>';
		$text .= $poster->getPostSystem("profile");
		$text .= '</div></div>';
		echo $text;
	}
	
	function getPosts($connection, $db, $poster) {
		$id = $_GET['id'];
		$data = array();
		
		$ids = $db->getConnections($connection, $id);
		$posts = $poster->getUserPosts($connection, $ids, $id);
		if ($posts != NULL) {
			$users = $poster->getPostingUsers($connection, $posts, $db, $id);
			$temp = array("postArray"=>$posts, "userArray"=>$users);
			array_push($data, $temp);
		} else { $data = NULL; }
		return $data;
	}		

    function generateProfile($connection, $db, $page){
		$profileInfo = $this->getProfileInfo($connection);
		$img = "/CSE-201-Project-Folder/resources/img/" . $profileInfo[5];
		$text = '<div class="container-fluid"><div class="row"><div class="col-xs-6">';
		if ($profileInfo[5] == "NULL") {
			$text .= '<img src="' . $img . '" style="width:50%" /></img>';
		} else if ($profileInfo[5] != "NULL") {
			$text .= '<img src="' . $img . '" style="width:50%" /></img>';
		}
		$text .= '<h2>' . $profileInfo[0] . " " . $profileInfo[1] . '</h2>';
		$text .= '<div class="profileInfo"><p>'. $profileInfo[2] .'</p>';
		$text .= '<p>'. $db->getCollege($connection, $profileInfo[3]) .'</p>';
		$text .= '<p>'. $profileInfo[4] .'</p></div>';
		$text .= $page->generateButtons($connection, $page, 1);
		$text .= '</div>';
		return $text;
	}	

	function getProfileInfo($db) {
        $profileInfo = array();

        $query = "Select * From users Where userID = " . $_GET["id"];
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $date = date("D, M d, Y", strtotime($row["bDate"]));
				$img = $row["srcImg"];
				if ($img == NULL) { $img = "basic.png"; }
                array_push($profileInfo, $row["fName"], $row["lName"], $date, $row["collegeID"], $row["country"], $img, $row["userID"]);
            }
        }
        return $profileInfo;
    }
	
	function displayUserFriendPosts($data, $connection, $db) {
		$text = '<div class="col-xs-6"><h1> Friend Posts:</h1>';
		$id = $_SESSION['userID'];
		$profileID = $_GET["id"];
		$postFound = False;
		foreach($data[0]["postArray"] as $row) {
			if ($row["IDs"]["partyTypeID"] == 1 && $row["IDs"]["partyID"] == $profileID) {
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
		if (!$postFound) { $text = '<div class="col-xs-6"><h1> No friend posts found </h2>'; }
		return $text;
	}
		
	// Old Functions
    function getName($db, $id) {
        $query = "Select * From user Where userID = " . $id;
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row["fName"]. " " .$row["lName"];
		}
	}
	

    function getPreviousPostInfo($db){
	   $posts = [];
	   $count = 0;
	   $id = $_GET['id'];
       $query = "SELECT * FROM posts WHERE userID = '$id'";
       $result = mysqli_query($db, $query);
       while($row = mysqli_fetch_assoc($result)){
          $posts[$count][0] = $row['post']; 
          $posts[$count][1] = $row['tStamp'];
          $posts[$count][2] = $row['postUserID'];
		  $count++;
       }
       return $posts;

    }

    // function generatePreviousPosts($db){
	    // $posts = $this->getPreviousPostInfo($db);
		// $personalInfo = $this->getProfileInfo($db);
        // $text =' <div class="container-fluid"><div class="row"><div class="col-xs-12"><h1>Posts</h1></div>';
		// foreach($posts as $post) {
			// $name = $this->getName($db, $post[2]);
			// $text .= '<div class="post-container col-xs-12"><h4 class="post-head"><a href="profile.php?id='. $post[2] .'">'. $name .'</a> posted on '. date("M jS, Y", strtotime($post[1])) .':</h4>';
			// $text .= '<p class="post-body">'. $post[0] .'</p></div>';
		// }
		// $text .= '</div></div>';
        // echo $text;
    // }
	
    function getFriends($connect)
    {
        $profileInfo = $this->getProfileInfo($connect);
        $id = $_SESSION['userID'];
        $query = "SELECT * FROM connections WHERE (otherID = '$profileInfo[6]' AND userID = '$id' AND otherPartyTypeID = 1)";
        $result = mysqli_query($connect, $query);
        $friends = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['userID1'] == $profileInfo[5])
                    array_push($friends, $row['userID1']);
                else
                    array_push($friends, $row['userID2']);
            }
        }
        return $friends;
    }

    function getFriendRequests($connect)
    {
        $requests = array();
        $id = $_SESSION['userID'];
        $query = "SELECT requesterID FROM requests WHERE requesteeID = '$id'";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($requests, $row['requesterID']);
                }
        }


        $text = ' <div class="container-fluid"><div class="row" style="align-items: right;"><div class="col-xs-12">';
        $text .= '<p>Friend Requests:</p><ul>';
        foreach ($requests as $request){
            $q = "SELECT lName, fName FROM user WHERE userID = '$request'";
            $r = mysqli_query($connect, $q);
            $row = mysqli_fetch_assoc($r);
            $text .= '<li>'.$row['fName']. ' ' . $row['lName'];
            $text .= '<form action="profile.php?id='.$id.'"method="post"><input type="button" value="Accept" name="requestButton"> </form></li>';
        }
        $text .= '</ul></div></div>';
        echo $text;
    }

}

?>