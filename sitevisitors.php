<?php
//date_default_timezone_set("");

//name and email collector
if(isset($_SESSION['email']) && isset($_SESSION['rank']) && isset($db_surname) && isset($db_othernames)){
    $email_visiter = $_SESSION['email'];
    $fullname_visiter = $db_surname . " " . $db_othernames;
} else {
        $fullname_visiter = "Not Gotten";
        $email_visiter = "Not Gotten";
}

//picture collector
if (isset($db_passport_img)) {
    if (!empty($db_passport_img) && $db_passport_img != null) {
        $pics_visiter = $db_passport_img;  
    } else {
        $pics_visiter = "Not Gotten";
    }
} else {
        $pics_visiter = "Not Gotten";
}

//other data collector
if (isset($conn) ) {
    if ($conn == true){
    $dater_visiter = DATE("D(d)-M-Y");
    $timer_visiter = DATE("h-i-s, a");
    $ipaddr = htmlspecialchars($_SERVER['REMOTE_ADDR']);
    $Browser_OS = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
    $page_visited = htmlspecialchars($_SERVER["REQUEST_URI"]);
    
    $sqlq = "INSERT INTO visitedmembers(dater, timer, ipaddr, browser_os, fullname, email, pics, page_visited) VALUES ('$dater_visiter', '$timer_visiter', '$ipaddr', '$Browser_OS', '$fullname_visiter', '$email_visiter', '$pics_visiter', '$page_visited')"; 
    $sqlqs = mysqli_query($conn, $sqlq);
    }
}

?>
