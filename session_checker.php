<?php
	if (!isset($_SESSION['mat_no']) || !isset($_SESSION['email']) || !isset($_SESSION['rank']) || !isset($_SESSION['phone_number'])) {
		header("location: nacos_log_out.php");
	} else if(isset($_SESSION['mat_no']) && isset($_SESSION['email']) && isset($_SESSION['rank']) && isset($_SESSION['phone_number'])) {
		$query_dash_data = $conn->prepare("SELECT * FROM `nacosites` WHERE email_address = ?");
        $query_dash_data->bind_param('s', $_SESSION['email']);
        $query_dash_data->execute();
        $query_dash_data_run_1 = $query_dash_data->get_result();
        if ($query_dash_data_run_1 == true && mysqli_num_rows($query_dash_data_run_1) === 1) {
            $db_id=""; $db_mat_no=""; $db_email_address=""; $db_surname=""; $db_othernames=""; $db_mobile_country_code=""; $db_aproval_disaproval=""; $db_phone_number=""; $db_secret_token=""; $db_lisenced_by=""; $db_Interested_skills=""; $db_marital_status=""; $db_about_me=""; $db_passport_img=""; $db_graduation_status=""; $db_sponsor_full_name=""; $db_my_res_address=""; $db_date_time_of_registration=""; $db_activation_status=""; $db_rank=""; 
        
            while ($rows = mysqli_fetch_assoc($query_dash_data_run_1)) {
               	$db_id = $rows['id'];
                $db_mat_no = $rows['mat_no'];
                $db_email_address = $rows['email_address'];
                $db_surname = $rows['surname'];
                $db_othernames = $rows['othernames'];
                $db_mobile_country_code = $rows['mobile_country_code'];
                // $db_aproval_disaproval = $rows['aproval_disaproval'];
                $db_phone_number = $rows['phone_number'];
                $db_secret_token = $rows['secret_token'];
                $db_lisenced_by = $rows['lisenced_by'];
                $db_Interested_skills = $rows['Interested_skills'];
                $db_marital_status = $rows['marital_status'];
                $db_about_me = $rows['about_me'];
                $db_passport_img = $rows['passport_img'];
                $db_graduation_status = $rows['graduation_status'];
                $db_sponsor_full_name = $rows['sponsor_full_name'];
                $db_my_res_address = $rows['my_res_address'];
                $db_date_time_of_registration = $rows['date_time_of_registration'];
                $db_activation_status = $rows['activation_status'];
                $db_rank = $rows['rank'];


                if ($db_activation_status == 0) {
                	header("Location: nacos_log_in.php?disapproved=yes");
                } else if($db_activation_status == 1) {
                	$last_login_date = DATE("D(d)-M-Y");
    				$last_login_time = DATE("h-i-s, a");
    				$last_ip_address = htmlspecialchars($_SERVER['REMOTE_ADDR']);
    				$last_browser_used = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);

    				
                	$query_dash_data = $conn->prepare("UPDATE nacosites SET last_browser_used='$last_browser_used', last_ip_address='$last_ip_address', last_login_date='$last_login_date', last_login_time='$last_login_time' WHERE email_address = ? AND id = ?");
        			$query_dash_data->bind_param('ss', $db_email_address, $db_id);    
        			$query_dash_data->execute();
                }
            }
        } else {
           	header("location: nacos_log_out.php");
        }
	} else {
		header("location: nacos_log_out.php");
	}

?>