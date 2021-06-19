<?php
	$con=new mysqli("localhost","root","","Bank");
     
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Customer Details</title>
</head>
<style type="text/css">
	body{
		margin:0;
		padding:1px;
		font-family: Arial, Helvetica, sans-serif;
	}
	nav{
		background-color: lightgrey;
		height:54px;
		display:inline-flex;
		width:100%;
		position:relative;
	}
	.logo{
		display:inline-flex;
	}
	.logo img{
		border-radius: 50%;	
	}	
	.ul1{
		margin-left:50%;
		height:54px;
		display: flex;
	}
	a{
		padding:15px 10px;
		text-decoration: none;
		color:grey;
		border-right: 1px solid #ccc;
	}
	a:hover{
		background-color:#FFFA;
	}
	table{
		position:absolute;
		width:80%;
		top:40%;
		left:50%;
		transform: translate(-50%,-50%); 
		background-color: lightgrey;
	}
	th{
		background-color:#A3D2ca;
	}
	th, td{
		text-align: center;
	}
</style>
<body>
	<nav>
		<span class="logo">
					<img src="Images/logo.jpg" style="width:50px;height:50px;margin:2px">
					<h4 style="width:200px;margin-left:7px;color:grey">Sparks Bank</h4>
		</span>
		<div class="ul1" >
			<a href="index.html" style="border-left: 1px solid #ccc">Home</a>
			<a href="viewcustomer.php">View Customers</a>
			<a href="transact.php">Transaction Record</a>
		</div>	
	</nav>
	<table cellspacing="0" cellpadding="10" border="1px">
		<tr>
			<th>S.No.</th>
			<th>Sender</th>
			<th>Receiver</th>
			<th>Amount</th>
			<th>Date & Time</th>
		</tr>
		<tr>
		<?php
			$sql="select * from transaction";
			$result=$con->query($sql);
			if($result->num_rows>0)
			{
				while($rows=$result->fetch_assoc())
				{
					echo "<td>".$rows['sno']."</td><td>".$rows['sender']."</td><td>".$rows['receiver']."</td><td>".$rows['balance']."</td><td>".$rows['datetime']."</tr>";
				}
			}
		?>
		</tr>
	</table>