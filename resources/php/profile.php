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

    function addPost($db, $entry, $id){
	    $time = date('Y-m-d H:i:s');
        $query = "INSERT INTO posts (post, tStamp, userID) VALUES ('$entry', '$time' , '$id' )";
        mysqli_query($db, $query);
		header("location: profile.php?id=". $id);
    }

    function getPreviousPostInfo($db){
	   $posts = [];
	   $count = 0;
	   $id = $_GET['id'];
       $query = "SELECT post, tStamp, userID FROM posts WHERE userID = '$id'";
       $result = mysqli_query($db, $query);
       while($row = mysqli_fetch_assoc($result)){
          $posts[$count][0] = $row['post']; 
          $posts[$count][1] = $row['tStamp'];
		  $count++;
       }
       return $posts;

    }

    function generatePreviousPosts($db){
	    $posts = $this->getPreviousPostInfo($db);
		$personalInfo = $this->getProfileInfo($db);
        $text =' <div class="container-fluid"><div class="row"><div class="col-xs-12"><h1>Posts</h1></div>';
		foreach($posts as $post) {
			$text .= '<div class="post-container col-xs-12"><h4 class="post-head"><a href="">'. $personalInfo[0] .' '. $personalInfo[1] .'</a> posted on '. date("M jS, Y", strtotime($post[1])) .':</h4>';
			$text .= '<p class="post-body">'. $post[0] .'</p></div>';
		}
		$text .= '</div></div>';
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