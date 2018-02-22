 <?php
	 define("s_v_r", "localhost", true);
	 define("u_s_r", "root", true);
	 define("pw","");
 	 global $dbCon;
    $dbCon = mysqli_connect(s_v_r,u_s_r,pw) AND 
	mysqli_select_db($dbCon ,"fixquick") or die("Not able to connect to DB ".mysqli_error($dbCon));?>

