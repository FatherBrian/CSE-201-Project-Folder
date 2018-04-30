<?php

class searchResults
{

    function generateUserResults($db, $formData){
		if ($formData != NULL) $results = $this->getResults($db, $formData);
        else $results = NULL;
		$text = '<div class="container-fluid"><div class="row">';
		if ($results != NULL) {
			foreach ($results as &$value) {
				$query = "Select * From users Where userID = '$value'";
				$qResult = mysqli_query($db, $query);
				$row = mysqli_fetch_assoc($qResult);
				$text .= $this->makeSearchProfile($db, $row);
			}
		} else { $text .= '<div class="col-xs-12"><h1> Users </h1><p>No users were found</div>'; }
		$text .= '</div></div>';
		echo $text;
    }

    function getResults($db, $formData)
    {
        $results = array();
        $query = "Select * From users Where fName LIKE '%$formData%' OR lName LIKE '%$formData%';";
		$qResult = mysqli_query($db, $query);
        if (mysqli_num_rows($qResult) > 0) {
            while ($row = mysqli_fetch_assoc($qResult)) {
                array_push($results, $row['userID']);
            }
        }
        return $results;

    }

	function makeSearchProfile($db, $row) {
		$date = date("D, M d, Y", strtotime($row["bDate"]));
		if ($row["srcImg"] == NULL) $img = "basic.png";
		else $img = $row["srcImg"];
		$img = "/CSE-201-Project-Folder/resources/img/". $img;
		$text = '<div class="col-xs-6 searchedPerson" style="padding-top:20px;">';
		$text .= '<img src="'. $img .'" style="width:50%; float:left; padding-right:50px;">';
		$text .= '<a href="/CSE-201-Project-Folder/website/profile.php?id='. $row["userID"] . '"><h2>' . $row["fName"] .  " " . $row["lName"] . '</h2></a>';
		$text .= '<p>' . $this->getCollege($db, $row["collegeID"]) . '</p>';
		$text .= '<p>' . $row["country"] . '</p>';
		$text .= '<p>Date of birth: ' . $date . '</p>';
        $text .= '</div>';
		return $text;
	}

	function getCollege($db, $id) {
		$query = "SELECT * FROM college Where collegeID = '$id'";
		$qResult = mysqli_query($db, $query);
		$row = mysqli_fetch_assoc($qResult);
		return $row["name"];
	}
	
}
?>