<?php
	session_start();

	$db = mysqli_connect('localhost', 'root', 'toor', 'shift');


	if (isset($_POST['swapmenu1'])) {
		$codeHost    =  ($_POST['c_code_host']);
		$nameHost  =  ($_POST['c_name_host']);
		$seatHost  = ($_POST['c_seat_host']);
		$shiftHost  =  ($_POST['c_shift_host']);
		$labelM    =  ($_POST['c_labelmain']);
		$label    =  ($_POST['c_label']);
		//datehost
		$day			=  ($_POST['day_host']);
		$month			=  ($_POST['month_host']);
		$year 	=  ($_POST['year_host']);
		//datevisit
		//$day2			=  ($_POST['day_visit']);
		//$month2			=  ($_POST['month_visit']);
		//$year2 	=  ($_POST['year_visit']);
		$codeVisit	=  ($_POST['c_code_visit']);
		$nameVisit	=  ($_POST['c_name_visit']);

		$dateHost = $year.$month.$day;
		//$dateVisit = $year2.$month2.$day2;


		$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_shift_host, c_labelmain, c_label, c_code_visit, c_name_visit)
		VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$shiftHost', '$labelM', '$label', '$codeVisit', '$nameVisit') ";
		mysqli_query($db, $insSQL);

		print $codeHost; echo "<br>";
		print $nameHost; echo "<br>";
		print $seatHost; echo "<br>";
		print $shiftHost; echo "<br>";
		print $labelM; echo "<br>";
		print $label; echo "<br>";
		print $codeVisit; echo "<br>";
	 	print $nameVisit; echo "<br>";

		header('location: index.php');

	}

	?>
