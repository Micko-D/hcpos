<?php 

if(isset($_POST['add'])){

	$imgurl = $_POST['file'];
	$prodname = $_POST['itemName'];
	$prodtype = $_POST['itemType'];
	$prodsize = $_POST['serving'];
	$prodprice = $_POST['itemPrice'];

	echo $imgurl . "<br>".$prodname . "<br>" . $prodtype ."<br>" . $prodsize . "<br>" . $prodprice. "<br>" ;

	$randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
echo $randomNumber;


}

 ?>