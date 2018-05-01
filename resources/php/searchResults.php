<?php

class searchResults
{
    function generateUserResults($connection, $db, $formData){
		if ($formData != NULL) $results = $this->getUserResults($connection, $db, $formData);
        else $results = NULL;
		$text = '<div class="container-fluid"><div class="row"><div class="col-xs-12"><h1> Users </h1></div>';
		if ($results != NULL) {
			foreach ($results as &$value) {
				$text .= $this->makeUserSearchProfile($connection, $db, $value);
			}
		} else { $text = '<div class="col-xs-12"><h1> Users </h1><p>No users were found</div>'; }
		$text .= '</div></div>';
		echo $text;
    }

    function generateGroupResults($connection, $db, $formData){
		if ($formData != NULL) $results = $this->getGroupResults($connection, $db, $formData);
        else $results = NULL;
		$text = '<div class="container-fluid"><div class="row"><div class="col-xs-12"><h1> Groups </h1></div>';
		if ($results != NULL) {
			foreach ($results as &$value) {
				$text .= $this->makeGroupSearchProfile($value);
			}
		} else { $text = '<div class="col-xs-12"><h1> Groups </h1><p>No groups were found</div>'; }
		$text .= '</div></div>';
		echo $text;
    }	
	
	
    function getUserResults($connection, $db, $formData) {
        $results = array();
        $query = "Select * From users Where fName LIKE '%$formData%' OR lName LIKE '%$formData%';";
		$qResult = mysqli_query($connection, $query);
        if (mysqli_num_rows($qResult) > 0) {
            while ($row = mysqli_fetch_assoc($qResult)) {
                array_push($results, $row['userID']);
            }
        }
		$results = $db->getUserInfo($connection, $results);
        return $results;
    }
	
    function getGroupResults($connection, $db, $formData) {
        $results = array();
        $query = "Select * From groups Where name LIKE '%$formData%';";
		$qResult = mysqli_query($connection, $query);
        if (mysqli_num_rows($qResult) > 0) {
            while ($row = mysqli_fetch_assoc($qResult)) {
                array_push($results, $row['groupID']);
            }
        }
		$results = $db->getGroupInfo($connection, $results);
        return $results;

    }

	function makeUserSearchProfile($connection, $db, $row) {
		$date = date("D, M d, Y", strtotime($row["bDate"]));
		$name = $row["fName"] .  " " . $row["lName"];
		if ($row["srcImg"] == NULL) $img = "basic.png";
		else $img = $row["srcImg"];
		$img = "/CSE-201-Project-Folder/resources/img/". $img;
		$text = '<div class="col-xs-6 searchedPerson" style="padding-top:20px;">';
		$text .= '<img src="'. $img .'" style="width:50%; float:left; padding-right:50px;">';
		$text .= '<a href="/CSE-201-Project-Folder/website/profile.php?id='. $row["id"] . '"><h2>' . $name . '</h2></a>';
		$text .= '<p>' . $db->getCollege($connection, $row["collegeID"]) . '</p>';
		$text .= '<p>' . $row["country"] . '</p>';
		$text .= '<p>Date of birth: ' . $date . '</p>';
        $text .= '</div>';
		return $text;
	}

	function makeGroupSearchProfile($row) {
		if ($row["srcImg"] == NULL) $img = "basic.png";
		else $img = $row["srcImg"];
		if (strlen($row["description"]) > 50) $word = substr($row["description"], 0, 49) . "...";
		else $word = $row["description"];
		$img = "/CSE-201-Project-Folder/resources/img/". $img;
		$text = '<div class="col-xs-6 searchedPerson" style="padding-top:20px;">';
		$text .= '<img src="'. $img .'" style="width:50%; float:left; padding-right:50px;">';
		$text .= '<a href="/CSE-201-Project-Folder/website/group.php?id='. $row["id"] . '"><h2>' . $row["name"] . '</h2></a>';
		$text .= '<p>' . $word . '</p>';
        $text .= '</div>';
		return $text;
	}	
	
}
?>