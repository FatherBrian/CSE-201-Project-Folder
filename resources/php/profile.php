<?php
class profile {

	function getProfileInfo($db){
	    $profileInfo = array();

	    $query = "Select * From user Where userID = " . $_GET["id"];
	    $result = mysqli_query($db, $query);

	    if(mysqli_num_rows($result) > 0){
	        while($row =mysqli_fetch_assoc($result)){
				$date = date("D, M d, Y", strtotime($row["bDate"]));
	            array_push($profileInfo, $row["fName"], $row["lName"], $date, $row["college"], $row["country"], $row["srcImg"]);
	        }
	    }

	    return $profileInfo;
    }

    function getPostSystem() {
        $text = ' <div class="container-fluid"><div class="row"><div class="col-l-300">
                  <form action="/CSE-201-Project-Folder/website/profile.php?id='.$_SESSION['userID'].'" style="padding-top:20px;" method="post">
				  <textarea id="posts" name="posts">Enter your status here!</textarea>
				  <input type="submit" name="submit" value="Post Status">
				  </form></div></div>';
        echo $text;
    }

    function addPost($db, $entry){
	    $id = $_SESSION['userID'];
	    $time = date('Y-m-d H:i:s');
        $query = "INSERT INTO posts (post, tstamp, userID) VALUES ('$entry', '$time' , '$id' )";
        mysqli_query($db, $query);
    }

    function getPreviousPostInfo($db){
	   $posts = array();
	   $id = $_SESSION['userID'];
       $query = "SELECT post, tstamp, userID FROM posts WHERE userID = '$id'";
       $result = mysqli_query($db, $query);
       while($row = mysqli_fetch_assoc($result)){
          array_push($posts, $row['post'] , $row['tStamp']);
       }
       echo $posts;

    }

    function generatePreviousPosts($db){
	    $posts = $this->getPreviousPostInfo($db);
        $text =' <div class="container-fluid"><div class="row">
        <div class="col-l-30"></div>
        <div class="col-l-60"><h2><ul>
        <li><h2>'.$posts[0].'</h2><p>'.$posts[1].'</p></li>
        <li><h2>'.$posts[2].'</h2><p>'.$posts[3].'</p></li>
        <li><h2>'.$posts[4].'</h2><p>'.$posts[5].'</p></li>
        <li><h2>'.$posts[6].'</h2><p>'.$posts[7].'</p></li>
        <li><h2>'.$posts[8].'</h2><p>'.$posts[9].'</p></li>
        </ul></h2></div></div>';
        echo $text;
    }

    function generateProfile($connect){
		$profileInfo = $this->getProfileInfo($connect);
		$img = "/CSE-201-Project-Folder/resources/img/". $profileInfo[5];		
        $text = '<div class="container-fluid"><div class="row"><div class="col-xs-6"><h2>';
		$text .= '<img src="'. $img .'" style="width:50%" />';
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