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
	<title>View Customer</title>
</head>
<style type="text/css">
	body{
		margin:0;
		padding:1px;
		font-family: Arial, Helvetica, sans-serif;
		background-color: #176;
	}
	nav{
		background-color: #233E8B;
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
	.ul1 a{
		padding:15px 10px;
		text-decoration: none;
		color:#fff;
		border-right: 1px solid #ccc;
	}
	.ul1 a:hover{
		background-color:#FFFA;
	}
	table{
		border:1px solid blue; 
		width:100%;
		background-color: #A9F1DF;
	}
	th{
		background-color: #a9f
	}
	th,td{
		border:1px solid blue;
		margin:0;
		padding:3px;
		height:40px;
		text-align: center;
	}
	td a{
		text-decoration: none;
		color:black;
		border:0;
		padding:15px 20px 15px 20px;
	}
	button{
		overflow: hidden;
		border:0;
		border-radius:3px;
	}
	button:hover{
		background-color: #aaaa
	}
</style>
<body>
	<nav>
		<span class="logo">
			<img src="Images/logo.jpg" style="width:50px;height:50px;margin:2px">
			<h4 style="width:200px;margin-left:7px;color:#fff">Sparks Bank</h4>
		</span>
		<div class="ul1" >
			<a href="index.html" style="border-left: 1px solid #ccc">Home</a>
			<a href="viewcustomer.php">View Customers</a>
			<a href="transact.php">Transaction Record</a>
		</div>	
	</nav>


	<div style="margin-top:25px;padding:0 30px 10px 30px">
		<h1 style="text-align: center; color:#c9f9e1;">Users' Details</h1>
		<table cellspacing='0'>
			<tr>
				<th>Customer Id</th>
				<th>Name</th>
				<th>Email</th>
				<th>Current Balance</th>
				<th>Operation</th>
			</tr>
			<?php
				$sql="select*from customer";
				$result=$con->query($sql);
				if($result->num_rows >0){
        	  	while($rows=$result->fetch_assoc()){
				echo "<tr><td>".$rows['cid']."</td><td>".$rows['name']."</td><td>".$rows['email']."</td><td>".$rows['c_blnc']."</td><td><button><a style='width:100%;height:100%' href='edit.php?id=".$rows['cid']."'>Transact</a></button></td></tr>";
					}
				}
			?>
		</table>
	</div>
</body>
</html>