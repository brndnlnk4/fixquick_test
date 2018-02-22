<?php
require "../pay/init.php";

echo "payment informatin: <br/>";

if(isset($_POST)){

	if($result->success == false){
		die('errors: '.print_r($result->errors));
	}///END if
	
	$amount = trim($_POST['amount']);
	$first_name = trim($_POST['firstName']);
	$last_name = trim($_POST['lastName']);
	$payment_nonce = trim($_POST['payment_method_nonce']);
	
	$result = Braintree_Transaction::sale([
	  'amount' => $amount,
	  'orderId' => 'order id',
	  'merchantAccountId' => 'a_merchant_account_id',
	  'paymentMethodNonce' => $payment_nonce,
	  'customer' => [
		'firstName' => $first_name,
		'lastName' => $last_name,
		'company' => 'Braintree',
		'phone' => '312-555-1234',
		'fax' => '312-555-1235',
		'website' => 'http://www.fixquick.co',
		'email' => 'drew@example.com'
	  ],
	//  'billing' => [
	//	'firstName' => 'Paul',
	//	'lastName' => 'Smith',
	//	'company' => 'Braintree',
	//	'streetAddress' => '1 E Main St',
	//	'extendedAddress' => 'Suite 403',
	//	'locality' => 'Chicago',
	//	'region' => 'IL',
	//	'postalCode' => '60622',
	//	'countryCodeAlpha2' => 'US'
	//  ],
	//  'shipping' => [
	//	'firstName' => 'Jen',
	//	'lastName' => 'Smith',
	//	'company' => 'Braintree',
	//	'streetAddress' => '1 E 1st St',
	//	'extendedAddress' => 'Suite 403',
	//	'locality' => 'Bartlett',
	//	'region' => 'IL',
	//	'postalCode' => '60103',
	//	'countryCodeAlpha2' => 'US'
	//  ],
	  'options' => [
		'submitForSettlement' => true
	  ]
	]);
	
}///END isset($_POST)

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>
			Payment Details
		</title>
	</head>
	
	<body>
		<form action=<?=htmlspecialchars()?> method="post">
			<div class="panel panel-default" align="center">
				<label for="transaction_id" class="bold pull-left">Transaction ID</label>
					<input type="name" value="<?=$result->transaction->id?>" class="form-control" name="transaction_id" />
				<label for="firstName" class="bold pull-left">First name</label>
					<input type="name" value="<?=$result->transaction->customer['firstName']?>" class="form-control" name="firstName" />
				<label for="lastName" class="bold pull-left">Last name</label>
					<input type="name" value="<?=$result->transaction->customer['lastName']?>" class="form-control" name="lastName" />
				<label for="amount" class="bold pull-left">Amount (USD)</label>
					<input type="number" class="form-control" value="<?=$result->transaction->amount." ".$result->transaction->currencyIsoCode?>" name="amount" readonly disbabled />
	
				<div class="center-block text-center" align="center"> 
					<div class="center-block inner-bottom-xs" align="center">
						<h2 class="h2 text-center">Success</h2>
					</div>
				</div>
			</div><!--/END panel-->
		</form>		
	</body>
</html>