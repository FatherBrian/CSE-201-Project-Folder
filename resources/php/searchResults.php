<?php

class searchResults
{

    function getResults($db, $formData)
    {
        $results = array();
        $query = "Select * From user Where fName LIKE '%$formData%' OR lName LIKE '%$formData%';";
		$qResult = mysqli_query($db, $query);
        if (mysqli_num_rows($qResult) > 0) {
            while ($row = mysqli_fetch_assoc($qResult)) {
                array_push($results, $row['userID']);
            }
        }
        return $results;

    }

	function makeSearchProfile($row) {
		$date = date("D, M d, Y", strtotime($row["bDate"]));
		$img = "/CSE-201-Project-Folder/resources/img/". $row["srcImg"];
		$text = '<div class="col-xs-6 searchedPerson" style="padding-top:20px;">';
		$text .= '<img src="'. $img .'" style="width:50%; float:left; padding-right:50px;">';
		$text .= '<a href="/CSE-201-Project-Folder/website/profile.php?id='. $row["userID"] . '"><h2>' . $row["fName"] .  " " . $row["lName"] . '</h2></a>';
		$text .= '<p>' . $row["college"] . '</p>';
		$text .= '<p>' . $row["country"] . '</p>';
		$text .= '<p>Date of birth: ' . $date . '</p>';
        $text .= '</div>';
		return $text;
	}


    function generateResults($db, $formData){
        $results = $this->getResults($db, $formData);
        $text = '<div class="container-fluid"><div class="row">';
        foreach ($results as &$value) {
            $query = "Select * From user Where userID = '$value'";
            $qResult = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($qResult);
			$text .= $this->makeSearchProfile($row);
        }
        $text .= '</div></div>';
        echo $text;
    }

}
?>