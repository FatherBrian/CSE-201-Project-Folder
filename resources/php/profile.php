<?php
class profile
{

    function getProfileInfo($db)
    {
        $profileInfo = array();

        $query = "Select * From user Where userID = " . $_GET["id"];
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $date = date("D, M d, Y", strtotime($row["bDate"]));
                array_push($profileInfo, $row["fName"], $row["lName"], $date, $row["college"], $row["country"], $row["srcImg"], $row["userID"]);
            }
        }
        return $profileInfo;
    }

    function getPostSystem()
    {
        $text = ' <div class="container-fluid"><div class="row"><div class="col-l-300">
                  <form action="/CSE-201-Project-Folder/website/profile.php?id=' . $_SESSION['userID'] . '" style="padding-top:20px;" method="post">
				  <textarea id="posts" name="posts"></textarea>
				  <input type="submit" name="submit" value="Post Status">
				  </form></div></div>';
        echo $text;
    }

    function addPost($db, $entry)
    {
        $id = $_GET['id'];
        $time = date('Y-m-d H:i:s');
        $query = "INSERT INTO posts (post, tStamp, userID) VALUES ('$entry', '$time' , '$id' )";
        mysqli_query($db, $query);
    }

    function getPreviousPostInfo($db)
    {
        $posts = array();
        $id = $_GET['id'];
        $query = "SELECT post, tStamp, userID FROM posts WHERE userID = '$id'";
        $result = mysqli_query($db, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $text = '<div class="col-xs-12"><h>' . $row['tStamp'] . '</h><h2>' . $row['post'] . '</h2></div>';
            array_push($posts, $text);
        }
        return $posts;

    }

    function generatePreviousPosts($db)
    {
        $posts = $this->getPreviousPostInfo($db);
        $text = ' <div class="container-fluid"><div class="row"><div class="col-xs-12"><h1><u>Posts</u></h1></div>';
        foreach ($posts as $post) {
            $text .= $post;
        }
        $text .= '</div></div>';
        echo $text;
    }


    function getFriends($connect)
    {
        $profileInfo = $this->getProfileInfo($connect);
        $id = $_SESSION['userID'];
        $query = "SELECT * FROM friends WHERE (userID1 = '$profileInfo[5]' AND userID2 = '$id') OR (userID2 = '$profileInfo[5]' AND userID1 = '$id')";
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


        $text = ' <div class="container-fluid"><div class="row" style="align-items: right;"><div class="col-l-300">';
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
        $profileInfo = $this->getProfileInfo($connect);
        $id = $_SESSION['userID'];

        $query = "INSERT INTO friends(userID1, userID2) VALUES ('$id', '$profileInfo[5]')";
        mysqli_query($connect, $query);

        $qr = "DELETE FROM requests WHERE requesterID = '$profileInfo[5]'";
        mysqli_query($connect, $qr);
    }

    function requestFriend($connect){
        $profileInfo = $this->getProfileInfo($connect);
        $id = $_SESSION['userID'];
        $otherID = $profileInfo[5];

        $query = "INSERT INTO requests(requesterID, requesteeID) VALUES ('$id', '$otherID')";
        mysqli_query($connect, $query);
    }

    function isFriend($connect){
        $profileInfo = $this->getProfileInfo($connect);
        $id = $_SESSION['userID'];
        $otherID = $profileInfo[5];

        $query = "SELECT * FROM friends WHERE (userID1 = '$otherID' AND userID2 = '$id') OR (userID2 = '$otherID' AND userID1 = '$id')";

        $result = mysqli_query($connect, $query);

        if(mysqli_num_rows($result) > 0){
            return true;
        }
        return false;

    }

    function generateFriendButton($connect){
        $profileInfo = $this->getProfileInfo($connect);
        $text = '';
        $friend = $this->isFriend($connect);
        if(!$friend){
            $text .= '<form action="..resources/php/profile.php?id='.$profileInfo[5].'" method="post"><input type="button" value="Add Friend" name="addFriend"></form>';
        }
        return $text;
    }

    function generateProfile($connect){
            $profileInfo = $this->getProfileInfo($connect);
            $img = "/CSE-201-Project-Folder/resources/img/" . $profileInfo[5];
            $text = '<div class="container-fluid"><div class="row"><div class="col-xs-6"><p>';
            $text .= $this->generateFriendButton($connect) . '</p>';
            if ($profileInfo[5] == "NULL") {
                $text .= '<img src="' . $img . '" style="width:50%" /></img>';
            } else if ($profileInfo[5] != "NULL") {
                $text .= '<img src="' . $img . '" style="width:50%" /></img>';
            }
            $text .= '<h2>' . $profileInfo[0] . " " . $profileInfo[1] . '</h2>';
            $text .= '<p>';
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