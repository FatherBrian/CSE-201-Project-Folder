<?php
class home {

	function generateHomePage($message, $db) {
		$text = '<div class="container-fluid"><div class="row"><div col-xs-12">'. $message;
		$text .= displayGroupPosts($db);
		$text .= displayFriendPosts($db);
		$text .= '</div></div>';
		echo $text;
	}

	function displayGroupPosts($db) {
        $query = "SELECT * FROM friends WHERE (userID1 = '$profileInfo[5]' AND userID2 = '$id') OR (userID2 = '$profileInfo[5]' AND userID1 = '$id')";
        $result = mysqli_query($connect, $query);
        $friends = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
			}
		}			
		return $text;
	}
	
	function displayFriendPosts() {
		return $text;		
	}
}	
?>