<?php
	session_start();

	$db = mysqli_connect('localhost', 'root', 'toor', 'shift');


	if (isset($_POST['swapmenu1'])) {
		$codeHost    =  ($_POST['c_code_host']);
		$nameHost  =  ($_POST['c_name_host']);
		$shiftHost  =  ($_POST['c_shift_host']);
		$labelM    =  ($_POST['c_labelmain']);
		$label    =  ($_POST['c_label']);
		$day			=  ($_POST['c_day_host']);
		$month			=  ($_POST['c_month_host']);
		$year 	=  ($_POST['c_year_host']);
		$codeVisit	=  ($_POST['c_code_visit']);
		$nameVisit	=  ($_POST['c_name_visit']);

		$date = $year.$month.$day;

		$selectType = "SELECT w_type FROM work WHERE w_date='$date' w_code='$codeHost' ";
		$qry =  mysqli_query($db, $selectType);
		$type = mysqli_fetch_array($qry);

		$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_type_host, c_shift_host, c_labelmain, c_label, c_code_visit, c_name_visit, c_date_visit)
		VALUES('$codeHost', '$nameHost', '$date', '$type', '$shiftHost', '$labelM', '$label', '$codeVisit', '$nameVisit', '$date') ";
		mysqli_query($db, $insSQL);

	}
	print $codeHost; echo "<br>";
	print $nameHost; echo "<br>";
	print $shiftHost; echo "<br>";
	print $labelM; echo "<br>";
	print $label; echo "<br>";
	print $codeVisit; echo "<br>";
 	print $nameVisit; echo "<br>";
	print $date; echo "<br>";
	print $type;

	?>
