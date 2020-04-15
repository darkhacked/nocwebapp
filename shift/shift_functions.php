<?php
	session_start();

	$db = mysqli_connect('localhost', 'root', 'toor', 'shift');

	if (isset($_POST['swapmenu1'])) {
		$codeHost    =  ($_POST['c_code_host']);
		$nameHost  =  ($_POST['c_name_host']);
		$shiftHost  =  ($_POST['c_shift_host']);
		$labelM    =  ($_POST['c_labelmain']);
		$label    =  ($_POST['c_label']);
		$day			=  ($_POST['day_host']);
		$month			=  ($_POST['month_host']);
		$year 	=  ($_POST['year_host']);
		$codeVisit	=  ($_POST['c_code_visit']);
		$color = "#ffff00";

		$dateHost = $year.$month.$day;

		// function ดึงชื่อพนักงานมาใส่ field c_name_visit
		$selectNamevisit = "SELECT user_name FROM users WHERE username = '$codeVisit'";
		$qry = mysqli_query($db, $selectNamevisit);
		while ($qryname = mysqli_fetch_array($qry)) {
			$nameVisit = $qryname["user_name"];
		}

		// select seat + status host
		$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
		$qry = mysqli_query($db, $selectSeathost);
		while ($qryname = mysqli_fetch_array($qry)) {
			$seatHost = $qryname["w_type"];
			$statusHost = $qryname["w_status"];
		}


		$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_labelmain, c_label, c_code_visit, c_name_visit, c_date_visit)
				VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$labelM', '$label', '$codeVisit', '$nameVisit', '$dateHost') ";
				mysqli_query($db, $insSQL);

		$updateStatus = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
		mysqli_query($db, $updateStatus);

		$updateStatus2 = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeVisit' AND w_date ='$dateHost'";
		mysqli_query($db, $updateStatus2);

				header('location: index.php');
	}


if (isset($_POST['swapmenu2'])) {
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$labelM    =  ($_POST['c_labelmain']);
	$label    =  ($_POST['c_label']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);
	$re   =  ($_POST['c_re1']);
	$re2   =  ($_POST['c_re2']);
	$color = "#ffff00";

	$dateHost = $year.$month.$day;
	$remark  = $re." - ".$re2;

	// select seat + status host
	$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qryname = mysqli_fetch_array($qry)) {
		$seatHost = $qryname["w_type"];
		$statusHost = $qryname["w_status"];
	}

	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_shift_host, c_seat_host, c_seat_stahost, c_labelmain, c_label, c_remark)
	VALUES('$codeHost', '$nameHost', '$dateHost', '$shiftHost', '$seatHost', '$statusHost', '$labelM', '$label', '$remark') ";
	mysqli_query($db, $insSQL);

	$updateStatus = "UPDATE work SET w_status = '$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus);

	header('location: index.php');

}


if (isset($_POST['swapmenu3'])){
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$labelM    =  ($_POST['c_labelmain']);
	$remark 	=  ($_POST['c_remark']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);
	$codeVisit	=  ($_POST['c_code_visit']);
	$color = "#ffff00";

	$dateHost = $year.$month.$day;

	// function ดึงชื่อพนักงานมาใส่ field c_name_visit
	$selectNamevisit = "SELECT user_name FROM users WHERE username = '$codeVisit'";
	$qry = mysqli_query($db, $selectNamevisit);
	while ($qryname = mysqli_fetch_array($qry)) {
		$nameVisit = $qryname["user_name"];
	}

	// select seat + status host
	$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qryname = mysqli_fetch_array($qry)) {
		$seatHost = $qryname["w_type"];
		$statusHost = $qryname["w_status"];
	}

	// select seat + status visit
	$selectSeatvisit = "SELECT w_type, w_status FROM work WHERE w_code='$codeVisit' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeatvisit);
	while ($qryname = mysqli_fetch_array($qry)) {
		$seatVisit = $qryname["w_type"];
		$statusVisit = $qryname["w_status"];
	}

	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_code_visit, c_name_visit, c_date_visit, c_seat_visit, c_seat_stavisit, c_shift_visit, c_labelmain, c_remark)
	VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$codeVisit', '$nameVisit', '$dateHost', '$seatVisit', '$statusVisit', '$shiftHost', '$labelM', '$remark') ";
	mysqli_query($db, $insSQL);

	$updateStatus = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus);

	$updateStatus2 = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeVisit' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus2);

	header('location: index.php');
}



if (isset($_POST['swapmenu4'])) {
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$labelM    =  ($_POST['c_labelmain']);
	$remark 	=  ($_POST['c_remark']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);

	$codeVisit  =  ($_POST['c_code_visit']);
	$day2			=  ($_POST['day_visit']);
	$month2			=  ($_POST['month_visit']);
	$year2 	=  ($_POST['year_visit']);
	$color = "#ffff00";


	$dateHost = $year.$month.$day;
	$dateVisit = $year2.$month2.$day2;

// select seat + status host
$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
$qry = mysqli_query($db, $selectSeathost);
while ($qryname = mysqli_fetch_array($qry)) {
	$seatHost = $qryname["w_type"];
	$statusHost = $qryname["w_status"];
}

//select name+shift visit
$selectNamevisit = "SELECT user_name, shift FROM users WHERE username = '$codeVisit'";
$qry = mysqli_query($db, $selectNamevisit);
while ($qryname = mysqli_fetch_array($qry)) {
	$nameVisit = $qryname["user_name"];
	$shiftVisit = $qryname["shift"];
}

// select seat + status visit
$selectSeatvisit = "SELECT w_type, w_status FROM work WHERE w_code='$codeVisit' AND w_date='$dateHost'";
$qry = mysqli_query($db, $selectSeatvisit);
while ($qryname = mysqli_fetch_array($qry)) {
	$seatVisit = $qryname["w_type"];
	$statusVisit = $qryname["w_status"];
}

//insert swap
$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_code_visit, c_name_visit, c_date_visit, c_seat_visit, c_seat_stavisit, c_shift_visit, c_labelmain, c_remark)
VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$codeVisit', '$nameVisit', '$dateVisit', '$seatVisit', '$statusVisit', '$shiftVisit', '$labelM', '$remark') ";
mysqli_query($db, $insSQL);

//update status
$updateStatus = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
mysqli_query($db, $updateStatus);

$updateStatus2 = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeVisit' AND w_date ='$dateVisit'";
mysqli_query($db, $updateStatus2);

header('location: index.php');

}




if (isset($_POST['swapmenu5'])) {
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$labelM    =  ($_POST['c_labelmain']);
	$label    =  ($_POST['c_label']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);
	$codeVisit	=  ($_POST['c_code_visit']);
	$color = "#ffff00";

	$dateHost = $year.$month.$day;

	// function ดึงชื่อพนักงานแทน
	$selectNamevisit = "SELECT user_name FROM users WHERE username = '$codeVisit'";
	$qry = mysqli_query($db, $selectNamevisit);
	while ($qryname = mysqli_fetch_array($qry)) {
		$nameVisit = $qryname["user_name"];
	}

	// select seat + status host
	$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qryname = mysqli_fetch_array($qry)) {
		$seatHost = $qryname["w_type"];
		$statusHost = $qryname["w_status"];
	}


	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_labelmain, c_label, c_code_visit, c_name_visit, c_date_visit)
			VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$labelM', '$label', '$codeVisit', '$nameVisit', '$dateHost') ";
			mysqli_query($db, $insSQL);

	$updateStatus = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus);


			header('location: index.php');

}


?>
