<h2 class='gwpm-content-title'> </h2>

<a href='/?page_id=6&page=profile&action=edit'><h3>View / Update your Profile</h3></a>
<br />
<a href='/?page_id=6&page=search&action=view'><h3>View all candidates</h3></a>
<br />


<br/>
<?php
 
if(current_user_can('matrimony_user')) {
 	echo "You are already a subscribed member." ; 
} else { 

	global $gwpm_activity_model ;
	$uid = get_current_user_id() ;
	
	if(isset($_POST['doSubscribe']) && $_POST['doSubscribe'] == 1) {
		$gwpm_activity_model->addActivityLog("subscribe", "Requested subscription", $uid) ;
		update_option("gwpm_user_sub_" . $uid, "true") ;
		$to = get_option('admin_email');  
		$from = get_option('admin_email');  
        $headers = 'From: '.$from . "\r\n";  
        $subject = "Registration successful"; 
        $msg = "Subscription request made by user : " . GWPM_USER_PREFIX . $uid . ". Change the user role to 'Matrimonial User' to approve. \n"  ;
        $msg .= get_option("siteurl") . '/' .  'wp-admin/user-edit.php?user_id=' . $uid . '#role' ;
        $msg .= "\n\nYou can check the Biodata of user at "  ;
        $msg .= get_option("siteurl") . '/' .  'matrimony/?page=profile&action=view&pid=' . $uid  ;
        wp_mail( $to, $subject, $msg, $headers );  
		echo "Your request has been submitted to Moderators. You will be notified once your request is accepted." ;
		
	} else {
		$isSubscribed = get_option("gwpm_user_sub_" . $uid) ;
		if($isSubscribed == "true") {
			echo "You have already requested for subscription. Please wait for the Admin to approve your request." ;

		} else {
			?>
			<div id="subscribeDIV">
			<form action="" method="post">  
			
			<label>Click on "Submit" button for Admin approval for displaying your Biodata on the site.
Your Biodata will be activated by Administrator within 4 to 5 days and you will be notified by email.</label>  
			<input type="input" name="doSubscribe" value="1" class="gwpm_hidden_fields"  />   
			<input type="submit" id="submitbtn" name="submitbtn" value="SUBMIT" />  
			</form> 
			</div>
			<?php 
		}
	}
} 

?>