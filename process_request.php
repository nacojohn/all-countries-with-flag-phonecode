<?php
spl_autoload_register(function ($class_name) {
	require_once 'libs/'.$class_name.'.php';
});

$condition = stripslashes($_GET['_request']);
$fetchData = new fetchData;

switch ($condition) {
	case 'all':
		$data = $fetchData->fetchAllRecord("tbl_country","`Country Name`","ASC");
		if($data === 0):
			$response = array('status'=>0,'message'=>"No available record to fetch");
		else:
			foreach ($data as $key => $value):
				$response[$key] = $value;
			endforeach;
		endif;

		echo json_encode($response);
	break;

	case 'getCountry':
		$countryCode = stripcslashes($_GET['_code']) ?? "";

		$data = $fetchData->fetchOneColumn("tbl_country","`Top Level Domain`",$countryCode);
		if($data === 0):
			$response = array('status'=>0,'message'=>"No available record to fetch");
		else:
			foreach ($data as $key => $value):
				$response[$key] = $value;
			endforeach;
		endif;

		echo json_encode($response);
	break;
}
?>