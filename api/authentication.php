<?php
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if (!empty((array) $request)) {
		$username = $request->username;
		$password = $request->password;

		if ($username == "test" && $password == "test") {
			echo json_encode((object) ["success" => true]);
		} else {
			echo json_encode((object) ["message" => "Fel användarnamn eller lösenord."]);
		}

	} else {
		echo 'no';
	}