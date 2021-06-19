<?php
	$con=new mysqli("localhost","root","","Bank");
     
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}
if(isset($_POST['submit']))
{
	$from=$_GET['id'];
	$to=$_POST['to'];
	$amount=$_POST['amount'];

	$sq="select*from customer where cid=$from";
	$query=$con->query($sq);
	$sq1=$query->fetch_assoc();//returns output of user from which the amount is to be transferred.

	$sq2="select * from customer where cid=$to";
	$query1=$con->query($sq2);
	$sq3=$query1->fetch_assoc();

	//constraints for insufficient, zero or negative value of amount
	if($amount < 0)
	{
		echo "<script type='text/javascript'>";
		echo "alert('O-o! Negative values cannot be transferred...')";//will show alert box
		echo "</script>";
	}
	else if($amount > $sq1['c_blnc'])
	{
		echo '<script type="text/javascript">';
        echo ' alert("Bad Luck! Insufficient Balance")';
        echo '</script>';
	}
	else if($amount == 0)
	{
		echo "<script type='text/javascript'>";
        echo "alert('Oops! Zero value cannot be transferred')";
        echo "</script>";
	}

	else {
		//deducting amount from the sender's account
		$newbalance=$sq1['c_blnc']-$amount;
		$sql="update customer set c_blnc=$newbalance where cid=$from";
		$con->query($sql);

		//adding the amount to the receiver's account
		$newbalance=$sq3['c_blnc']+$amount;
		$sql="update customer set c_blnc=$newbalance where cid=$to";
		$con->query($sql);

		$sender=$sq1['name'];
		$receiver=$sq3['name'];
		$sql="insert into transaction(`sender`,`receiver`,`balance`) values('$sender','$receiver','$amount')";
		$query=$con->query($sql);
		if($query){
			echo "<script> alert('Transaction Successful');
                                     window.location='transact.php';
                           </script>";
		}
		$newbalance=0;
		$amount=0;
	}
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
		background-color: #F58634;
	}
	nav{
		background-color: #00AF91;
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
		color:#fff;
		border-right: 1px solid #ccc;
	}
	a:hover{
		background-color:#FFFA;
	}
	table{
		position:absolute;
		width:80%;
		background-color:#A3D2ca;
	}
	th, td{
		text-align: center;
	}
	.table{
		top:80%;
		left:-100%;
		padding:2% 10%;
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

	<form method="post" name="tcredit">
		<div class="table">
			<div style="margin-bottom:150px">
				<h1 style="text-align: center;color:#fff">Transaction</h1>
				<table cellspacing="0" cellpadding="10" border="1px">
					<tr>
						<th>Customer Id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Current Balance</th>
					</tr>
					<?php
						$id=$_GET['id'];
						$sql="select * from customer where cid= $id";
						$result=$con->query($sql);
						if($result->num_rows >0){
       			   			while($rows=$result->fetch_assoc()){
								echo "<tr><td>".$rows['cid']."</td><td>".$rows['name']."</td><td>".$rows['email']."</td><td>₹".$rows['c_blnc']."</td></tr>";
							}
						}
					?>
				</table>
			</div>
			<label style="color:white;width:100%">Transfer to:</label><br><br>
			<select name="to" required style="height: 30px;border-radius:5px">
				<option value="" disabled selected="" style="width:981px;">Choose</option>
				<?php
					$s="select * from customer where cid!=$id";
					$re=$con->query($s);
					if(!$re)
					{
						echo "Error".$s."<br>".$con->error_log(message);
					}
					while($row=$re->fetch_assoc()){
				?>
				<option value="<?php echo $row['cid']?>">
					<?php echo $row['name'];?> (Blanace: <?php echo $row['c_blnc'];?>)
				</option>
				<?php
					}
				?>
			</select><br><br><br>
			<label style="color:white;">Amount:</label><br><br>
			<input type="number" name="amount" required  style="width:1005px;height: 24px;border-radius:5px"	><br><br>
			<div style="align-content: center;padding:4% 45%">
				<button name="submit" type="submit" style="text-align: center;width:100px">Transfer</button>
			</div>
		</div>


</body>
</html>