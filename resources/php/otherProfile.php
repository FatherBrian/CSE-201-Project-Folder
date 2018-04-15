<?php
/**
 * Created by PhpStorm.
 * User: brianfotheringham
 * Date: 4/15/18
 * Time: 12:02 PM
 */

class otherProfile
{
    function getProfileInfo($db, $newID){
        $profileInfo = array();

        $id = $newID;

        $query = "Select * From user Where userID = '$id'";
        $result = mysqli_query($db, $query);

        if(mysqli_num_rows($result) > 0){
            while($row =mysqli_fetch_assoc($result)){
                $date = date("D, M d, Y", strtotime($row["bDate"]));
                array_push($profileInfo, $row["fName"], $row["lName"], $date, $row["college"], $row["country"]);
            }
        }

        return $profileInfo;
    }

    function generateProfile($connect){
        $profileInfo = $this->getProfileInfo($connect);
        $text = '<div class="container-fluid"><div class="row"><div class="col-xs-6"><h2>';
        $text .= '<img src="/CSE-201-Project-Folder/resources/img/basic.png" style="width:50%" />';
        $text .= '<h2>' . $profileInfo[0] . " " . $profileInfo[1] . '</h2>';
        $text .=  '<p>';
        $text .= $profileInfo[2];
        $text .= '</p><p>';
        $text .= $profileInfo[3];
        $text .= '</p><p>';
        $text .= $profileInfo[4];
        $text .= '</h2></div></div>';
        echo $text;
    }
}
?>