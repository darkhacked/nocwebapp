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

		$dateHost = $year.$month.$day;

		// function ดึงชื่อพนักงานมาใส่ field c_name_visit
		$selectNamevisit = "SELECT user_name FROM users WHERE username = '$codeVisit'";
		$qry = mysqli_query($db, $selectNamevisit);
		while ($qryname = mysqli_fetch_array($qry)) {
			$nameVisit = $qryname["user_name"];
		}

		// select seat host
		$selectSeathost = "SELECT w_type FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
		$qry = mysqli_query($db, $selectSeathost);
		while ($qryname = mysqli_fetch_array($qry)) {
			$seatHost = $qryname["w_type"];
		}


		$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_shift_host, c_labelmain, c_label, c_code_visit, c_name_visit, c_date_visit)
				VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$shiftHost', '$labelM', '$label', '$codeVisit', '$nameVisit', '$dateHost') ";
				mysqli_query($db, $insSQL);

		$updateTable = "UPDATE work SET w_type = '$seatHost*' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
		mysqli_query($db, $updateTable);

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

	$dateHost = $year.$month.$day;
	$remark  = $re." - ".$re2;

	// select seat host
	$selectSeathost = "SELECT w_type FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qryname = mysqli_fetch_array($qry)) {
		$seatHost = $qryname["w_type"];
	}

	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_shift_host, c_seat_host,c_labelmain, c_label, c_remark)
	VALUES('$codeHost', '$nameHost', '$dateHost', '$shiftHost', '$seatHost', '$labelM', '$label', '$remark') ";
	mysqli_query($db, $insSQL);

	$updateTable = "UPDATE work SET w_type = '$seatHost*' WHERE work . w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateTable);

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

	$dateHost = $year.$month.$day;

	// function ดึงชื่อพนักงานมาใส่ field c_name_visit
	$selectNamevisit = "SELECT user_name FROM users WHERE username = '$codeVisit'";
	$qry = mysqli_query($db, $selectNamevisit);
	while ($qryname = mysqli_fetch_array($qry)) {
		$nameVisit = $qryname["user_name"];
	}

	// select seat host
	$selectSeathost = "SELECT w_type FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qryname = mysqli_fetch_array($qry)) {
		$seatHost = $qryname["w_type"];
	}

	// select seat visit
	$selectSeatvisit = "SELECT w_type FROM work WHERE w_code='$codeVisit' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeatvisit);
	while ($qryname = mysqli_fetch_array($qry)) {
		$seatVisit = $qryname["w_type"];
	}

	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_shift_host, c_code_visit, c_name_visit, c_date_visit, c_seat_visit, c_shift_visit, c_labelmain, c_remark)
	VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$shiftHost', '$codeVisit', '$nameVisit', '$dateHost', '$seatVisit', '$shiftHost', '$labelM', '$remark') ";
	mysqli_query($db, $insSQL);

	$updateTable = "UPDATE work SET w_type = '$seatHost*' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateTable);

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


	$dateHost = $year.$month.$day;
	$dateVisit = $year2.$month2.$day2;

// select seat host
$selectSeathost = "SELECT w_type FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
$qry = mysqli_query($db, $selectSeathost);
while ($qryname = mysqli_fetch_array($qry)) {
	$seatHost = $qryname["w_type"];
}

//select name+shift visit
$selectNamevisit = "SELECT user_name, shift FROM users WHERE username = '$codeVisit'";
$qry = mysqli_query($db, $selectNamevisit);
while ($qryname = mysqli_fetch_array($qry)) {
	$nameVisit = $qryname["user_name"];
	$shiftVisit = $qryname["shift"];
}

//select seat visit
$selectSeatvisit = "SELECT w_type FROM work WHERE w_code='$codeVisit' AND w_date='$dateVisit'";
$qry = mysqli_query($db, $selectSeatvisit);
while ($qryname = mysqli_fetch_array($qry)) {
	$seatVisit = $qryname["w_type"];
}

//insert swap
$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_shift_host, c_code_visit, c_name_visit, c_date_visit, c_seat_visit, c_shift_visit, c_labelmain, c_remark)
VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$shiftHost', '$codeVisit', '$nameVisit', '$dateVisit', '$seatVisit', '$shiftVisit', '$labelM', '$remark') ";
mysqli_query($db, $insSQL);

//update *
$updateTable = "UPDATE work SET w_type = '$seatHost*' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
mysqli_query($db, $updateTable);

header('location: index.php');

}

?>
