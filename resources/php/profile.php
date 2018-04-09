<?php
class profile {

	function getProfileInfo($db){
	    $profileInfo = array();

	    $userid = $_SESSION["userID"];

	    $query = "Select * From user Where userID = '$userid'";
	    $result = mysqli_query($db, $query);

	    if(mysqli_num_rows($result) > 0){

	        while($row =mysqli_fetch_assoc$result)){
	            array_push($profileInfo, $row["fName"], $row["lName"], $row["bDate"], $row["college"], $row["country"]);
	        }
	    }

	    return $profileInfo;
    }

    function generateProfile(){
        $profileInfo = getProfileInfo($connect);

        $text = '<div class="container-fluid">
                 <div class="row">
                    <div class="col-xs-6">
                	<h2>';
        $text = $text + $profileInfo[0];
        $text = $text + '</h2>
                         </div>
                         <div class = "col-xs-6">
                         <h2>';
        $text = $text + $profileInfo[1];
        $text = $text + '</h2>
                           </div>
                           <div class = "col-xs-6">
                           <h2>';
        $text = $text + profileInfo[2];
        $text = $text + '</h2>
                           </div>
                           <div class = "col-xs-6">
                           <h2>';
        $text = $text + profileInfo[3];
        $text = $text + '</h2>
                           </div>
                           <div class = "col-xs-6">
                           <h2>';
        $text = $text + profileInfo[4];
        $text = $text + '</h2>
                          </div>
                          </div>';

        echo $text;




    }
}
?>