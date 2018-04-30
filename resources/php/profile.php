<?php
class profile
{

	// New Functions
	function generateProfilePage($connection, $db, $poster) { 
		$text = "";
		// if ($message != NULL) { $text .= $message; }
		$text .= '<div class="container-fluid"><div class="row">';
		$text .= $this->generateProfile($connection);
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
			$users = $poster->getPostingUsers($connection, $posts, $db);
			$temp = array("postArray"=>$posts, "userArray"=>$users);
			array_push($data, $temp);
		} else { $data = NULL; }
		return $data;
	}		

    function generateProfile($connect){
		$profileInfo = $this->getProfileInfo($connect);
		$img = "/CSE-201-Project-Folder/resources/img/" . $profileInfo[5];
		$text = '<div class="container-fluid"><div class="row"><div class="col-xs-6">';
		if ($profileInfo[5] == "NULL") {
			$text .= '<img src="' . $img . '" style="width:50%" /></img>';
		} else if ($profileInfo[5] != "NULL") {
			$text .= '<img src="' . $img . '" style="width:50%" /></img>';
		}
		$text .= '<h2>' . $profileInfo[0] . " " . $profileInfo[1] . '</h2>';
		$text .= '<div class="profileInfo"><p>'. $profileInfo[2] .'</p>';
		$text .= '<p>'. $profileInfo[3] .'</p>';
		$text .= '<p>'. $profileInfo[4] .'</p></div>';
		// $text .= $this->generateFriendButton($connect); 	
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
		$postFound = False;
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
	
    function addPost($db, $entry, $id, $postId){
	    $time = date('Y-m-d H:i:s');
        $query = "INSERT INTO posts (post, tStamp, userID, postUserID) VALUES ('$entry', '$time' , '$id', '$postId')";
        mysqli_query($db, $query);
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

    function acceptFriend($connect){
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];

        $query = "INSERT INTO friends(userID1, userID2) VALUES ('$id', '$otherID')";
        mysqli_query($connect, $query);

        $query = "DELETE FROM requests WHERE (requesterID = '$otherID' and requesteeID = '$id')";
        mysqli_query($connect, $query);
		
		header ("location: profile.php?id=". $otherID);
    }

    function deleteFriend($connect){
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];

        $query = "DELETE FROM friends WHERE (userID1 = '$id' and userID2 = '$otherID') or (userID2 = '$id' and userID1 = '$otherID')";
        mysqli_query($connect, $query);
		header ("location: profile.php?id=". $otherID);
	}
	
    function sendRequestFriend($connect){
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];

        $query = "INSERT INTO requests(requesterID, requesteeID) VALUES ('$id', '$otherID')";
        mysqli_query($connect, $query);
		header ("location: profile.php?id=". $otherID);
    }

    function removeRequestFriend($connect){
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];

        $query = "DELETE FROM requests WHERE requesterID = '$id' and requesteeID = '$otherID'";
        mysqli_query($connect, $query);
		header ("location: profile.php?id=". $otherID);
    }
	
	
	function getButtonStatus($connect, $otherID) {
        $profileInfo = $this->getProfileInfo($connect);
        $id = $_SESSION['userID'];
		if ($id == $otherID) { return "Same person"; }
        $query = "SELECT * FROM friends WHERE (userID1 = '$otherID' AND userID2 = '$id') OR (userID2 = '$otherID' AND userID1 = '$id')";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0){
            return "Friend";
        } else {
			$query2 = "SELECT * FROM requests WHERE (requesterID = '$id' AND requesteeID = '$otherID')";
			$result2 = mysqli_query($connect, $query2);
			if(mysqli_num_rows($result2) > 0) { return "Sent Request"; } 
			$query3 = "SELECT * FROM requests WHERE (requesterID = '$otherID' AND requesteeID = '$id')";
			$result3 = mysqli_query($connect, $query3);
			if(mysqli_num_rows($result3) > 0) { return "Recieved Request"; } 			
			else { return "No Sent Request"; }
		}
	}
	
    function generateFriendButton($connect){
        $text = '';
        $friendStatus = $this->getButtonStatus($connect, $_GET['id']);
        if($friendStatus == "Friend") {
			$text .= '<div class="col-xs-3">';
            $text .= '<form action="?action=deleteFriend&id='.$_GET['id'].'" method="post">';
			$text .= '<input class="addFriendButton" type="submit" value="Delete Friend" name="addFriend"></form></div>';
        } else if ($friendStatus == "Sent Request") {
			$text .= '<div class="col-xs-3">';
            $text .= '<form action="?action=removeFriendRequest&id='.$_GET['id'].'" method="post">';
			$text .= '<input class="addFriendButton" type="submit" value="Remove Friend Request" name="addFriend"></form></div>';
		} else if ($friendStatus == "No Sent Request") {
			$text .= '<div class="col-xs-3">';
            $text .= '<form action="?action=sendFriendRequest&id='.$_GET['id'].'" method="post">';
			$text .= '<input class="addFriendButton" type="submit" value="Send Friend Request" name="addFriend"></form></div>';			
		} else if ($friendStatus == "Recieved Request") {
			$text .= '<div class="col-xs-3">';
            $text .= '<form action="?action=addFriend&id='.$_GET['id'].'" method="post">';
			$text .= '<input class="addFriendButton" type="submit" value="Accept Friend Request" name="addFriend"></form></div>';			
		}
        return $text;
    }

}

?>