 <?php
 
	if (isset($_POST['courseName']) && isset($_POST['courseDate']) &&
        isset($_POST['applicantName'])&& isset($_POST['applicantEmail']) && isset($_POST['applicantAddress']) &&
        isset($_POST['applicantJob']) && isset($_POST['levelOfDifficulty'])) {
        //course
		$courseName = $_POST['courseName'];
		$courseDate = $_POST['courseDate'];
		$levelOfDifficulty = $_POST['levelOfDifficulty'];

		//applicant
		$applicantName = $_POST['applicantName'];
		$applicantAddress = $_POST['applicantAddress'];
		$applicantJob = $_POST['applicantJob'];

		//company
		$companyName = $_POST['companyName'];
		$companyAddress = $_POST['companyAddress'];
		$companyNIP = $_POST['companyNIP'];

		//data
		$data = $_POST['data'];
		$participantArray = json_decode($data, true); //table
	
				
		//sql host connect
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "work";
        $conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
		if($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
		// DB row
			$query2 = "INSERT INTO course(courseName, courseData, levelofDifficulty) VALUES('$courseName', '$courseDate', '$levelOfDifficulty')";
			$run = mysqli_query($conn, $query2) or die(mysqli_error($conn));

			$latest_id =  mysqli_insert_id($conn);    // id
			
			$query = "INSERT INTO registration(ID ,applicantName,applicantaddress, applicantJob, companyName, companyAddress, companyNIP) VALUES($latest_id, '$applicantName', '$applicantAddress', '$applicantJob', '$companyName', '$companyAddress', '$companyNIP')";
			$run2 = mysqli_query($conn, $query) or die(mysqli_error($conn));
			
			foreach($participantArray as $participant){
				$participantName = $participant['name'];
				$participantAge = $participant['age'];
				$participantJob = $participant['job'];
				echo $participantName.' '.$participantAge.' '.$participantJob.'<br/>';

				$run3 = mysqli_query($conn, "INSERT INTO cadet(IDregister, participantName,participantAge, participantjob) VALUES($latest_id, '$participantName', '$participantAge', '$participantJob')")  or die(mysqli_error($conn));
		  }

			if($run &&$run2 && $run3){
				echo "Success! \n";
			}
			else{
				echo "Error problem!";
			}
			mysqli_close($conn);
        }

		
    }
?> 
