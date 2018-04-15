<?php
/**
 * Created by PhpStorm.
 * User: brianfotheringham
 * Date: 4/15/18
 * Time: 12:52 PM
 */

class searchResults
{

    function getResults($db)
    {
        $results = array();
        $search = $_POST['search'];

        $query = "Select fName, lName From user Where fName LIKE %$search% OR lName LIKE %$search%";
        $qResult = mysqli_query($db, $query);
        if (mysqli_num_rows() > 0) {
            while ($row = mysqli_fetch_assoc($qResult)) {
                array_push($results, $row['userID']);
            }
        }
        return $results;

    }


    function generateResults($db){
        $results = $this->getResults($db);

        $text = '<div class="container-fluid"><div class="row"><div class="col-xs-6">';
        foreach ($results as &$value) {
            $query = "Select fName, lName From user Where userID = '$value'";
            $qResult = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($qResult);
            $text .= '<p>' . $row['fName'] . ' ' . $row['lName'] . '</p>';
        }
        $text .= '</div></div></div>';
        echo $text;
    }
}

?>