<?php
	class employee{
		public $first_name;
		public $last_name;
		public $department;
		public $idNum;
		public $hireDate;

		public function __construct($fName, $lName, $dept){
			$this->first_name = $fName;
			$this->last_name = $lName;
			$this->department = $dept;
			$this->hireDate = date(DATE_COOKIE);
			//Make sure idNum is unique
			$jsonTemp = file_get_contents("http://localhost/Lab7/employee_list.json", true);
			$tempArray = json_decode($jsonTemp, true);
			$idTemp = rand(10000000,99999999);
			$idClear = false;
			while(!$idClear){
				$idClear = true;
				for($i=0;$i<count($tempArray);$i++){
					if(idTemp==$tempArray[$i]->idNum){
						$idTemp = rand(10000000,99999999);
						$idClear = false;
					}
				}
			}
			$this->idNum = $idTemp;
			
		}
	}

	//get data from the form
	$fName = $_POST['First_Name'];
	$lName = $_POST['Last_Name'];
	$dept = $_POST['Department'];

	$new = new employee($fName,$lName,$dept);
	$newJSON = json_encode($new);

	
	//Read JSON file
	$jsonFile = file_get_contents("http://localhost/Lab7/employee_list.json", true);
	$jsonArray = json_decode($jsonFile, true);
	$jsonArray[] = $new;
	$arrayLength = count($jsonArray);

	/*
	//Write to JSON file
	file_put_contents("/Applications/XAMPP/xamppfiles/htdocs/Lab7/employee_list.json",json_encode($jsonArray));
	*/

	
	//Test for Array Check
	$arrayLength = count($jsonArray);
	echo $arrayLength;
	for($i=0;$i<$arrayLength;$i++){
		echo json_encode(($jsonArray[$i]));
		echo '<br>';
	}
	

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="author" content="Alexander Paz">
  <title>Lab 7</title>
  <link rel="stylesheet" type="text/css" href="Lab7.css">
</head>
<body>
  <main>
    <h1>Add an Employee</h1>
      	<form action="add_employee.php" method="post">
	      First Name<br>
	      <input type="String" name="First_Name" id="name_1" value=<?php echo $fName?> ><br>
	      Last Name<br>
	      <input type="String" name="Last_Name" id="name_2" value=<?php echo $lName?> > <br>
	      Department<br>
	      <select name="Department" id="Department" value=<?php echo $dept ?> >
	        <option value="Engineering">Engineering</option>
	        <option value="Comp_Sci">Comp Sci</option>
	        <option value="IT">IT</option>
	      </select><br>
	      <button>Submit</button>
    	</form><p>
    	<result>
    		<resultHead>Employee Added</resultHead><p>


    		<label>Name:</label>
    		<span><?php echo $lName ?>, <?php echo $fName ?></span><br>

    		<label>Department:</label>
    		<span><?php echo $dept ?></span><br>

    		<label>Employee ID:</label>
    		<span><?php echo $new->idNum ?></span><br>

    		<label>Hire Date:</label>
    		<span><?php echo $new->hireDate ?></span><br>

    		<label>Total Employees:</label>
    		<span><?php echo $arrayLength ?></span>
    	</result>
  </main>
</body>
</html>