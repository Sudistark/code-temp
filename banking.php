

<?php

require('db.php');
session_start();


function get_balance($id)
{
	global $con;
	$id = (int)$id;
	$query = "select balance from users where id =" . $id;
	$result = $con->query($query);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			return $row["balance"];
		}
	}
	$con->close();
}

function account_exist($id)
{
	global $con;
	$id = (int)$id;
	$query = "SELECT * FROM `users` WHERE id='$id' ";
	$result = mysqli_query($con, $query) or die("Error");
	$rows = mysqli_num_rows($result);
	if ($rows > 0) {
		return true;
	}
	return false;
}

function transfere_money($amount, $receiver_account)
{
	global $con;
	$amount = (int)$amount;
	$receiver_account = (int)$receiver_account;
	$id = (int)$_SESSION['username'];
	if (!account_exist($receiver_account)) {
		die("receiver_account doesn't exist");
	}
	if ($amount < 0) {
		die("Negative numbers are not allowed");
	}
	if ($amount > get_balance($id)) {
		die('Insufficient funds !');
	}
	$sql = "UPDATE users SET balance=balance-" . $amount . " WHERE id=" . $id;

	if ($con->query($sql) === TRUE && get_balance($id)>=0) {
		$sql = "UPDATE users SET balance=balance+" . $amount . " WHERE id=" . $receiver_account;
		$con->query($sql);
		echo "Transfere complete!" . "<br>";
		echo "Amount: $" . $amount . "<br>";
		echo "From Account: " . $id . "<br>";
		echo "To Account: " . $receiver_account . "<br>";
		echo "<br> <button onclick='history.back()'>Go Back</button>";
	} else {
		echo "Error updating record";
		echo "<br> <button onclick='history.back()'>Go Back</button>";
	}
}

function is_vip()
{
	if (get_balance($_SESSION['username']) < 1000000) {
		return false;
	}
	return true;
}




?>



