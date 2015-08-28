<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="Templates/base.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Untitled Document</title>
	<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<div id="Page">
<div id="Header">
  <img src="image/CurlingSheetTitle.png" />
  <ul>
	<li><a href="index.php"><img src="image/BlueCurlingStone20L.png"/>Home</a></li>
	<li><a href="aboutus.php"><img src="image/RedCurlingStone20L.png"/>About Us</a></li>
	<li><a href="joinus.php"><img src="image/BlueCurlingStone20L.png"/>Join Us</a></li>
	<li><a href="payment.php"><img src="image/RedCurlingStone20L.png"/>Payment</a></li>
	<li><a href="schedule.php"><img src="image/BlueCurlingStone20L.png"/>Schedule</a></li>
	<li><a href="http://bit.ly/atlcurling"><img src="image/RedCurlingStone20L.png"/>Facebook</a></li>
	<li><a href="http://atlcurling.wikia.com"><img src="image/BlueCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="contactus.php"><img src="image/RedCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
  <div class="colleft">
    <div class="col1"> 
	  <!-- InstanceBeginEditable name="body" -->	
	  
	  
	  
	  <?php
require_once 'CallerService.php';
require_once 'constants.php';

session_start();

$API_UserName = API_USERNAME;
$API_Password = API_PASSWORD;
$API_Signature = API_SIGNATURE;
$API_Endpoint = API_ENDPOINT;
$subject = SUBJECT;

$token = $_REQUEST['token'];

$getAuthModeFromConstantFile = true;
//$getAuthModeFromConstantFile = false;
$nvpHeader = "";

if(!$getAuthModeFromConstantFile) {
	//$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
	//$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
	$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
} else {
	if(!empty($API_UserName) && !empty($API_Password) && !empty($API_Signature) && !empty($subject)) {
		$AuthMode = "THIRDPARTY";
	}else if(!empty($API_UserName) && !empty($API_Password) && !empty($API_Signature)) {
		$AuthMode = "3TOKEN";
	}else if(!empty($subject)) {
		$AuthMode = "FIRSTPARTY";
	}
}
switch($AuthMode) {
	
	case "3TOKEN" : 
			$nvpHeader = "&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature);
			break;
	case "FIRSTPARTY" :
			$nvpHeader = "&SUBJECT=".urlencode($subject);
			break;
	case "THIRDPARTY" :
			$nvpHeader = "&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature)."&SUBJECT=".urlencode($subject);
			break;		
	
}

if(! isset($token)) {

		/* The servername and serverport tells PayPal where the buyer
		   should be directed back to after authorizing payment.
		   In this case, its the local webserver that is running this script
		   Using the servername and serverport, the return URL is the first
		   portion of the URL that buyers will return to after authorizing payment
		   */
		   $serverName = $_SERVER['SERVER_NAME'];
		   $serverPort = $_SERVER['SERVER_PORT'];
		   $url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);

		   $currencyCodeType=$_REQUEST['currencyCodeType'];
		   $paymentType=$_REQUEST['paymentType'];

           $personName        = $_REQUEST['PERSONNAME'];
		   $SHIPTOSTREET      = $_REQUEST['SHIPTOSTREET'];
		   $SHIPTOCITY        = $_REQUEST['SHIPTOCITY'];
		   $SHIPTOSTATE	      = $_REQUEST['SHIPTOSTATE'];
		   $SHIPTOCOUNTRYCODE = $_REQUEST['SHIPTOCOUNTRYCODE'];
		   $SHIPTOZIP         = $_REQUEST['SHIPTOZIP'];
		   $L_NAME0           = $_REQUEST['L_NAME0'];
		   $L_AMT0            = $_REQUEST['L_AMT0'];
		   $L_QTY0            =	$_REQUEST['L_QTY0'];
		   $L_NAME1           =	$_REQUEST['L_NAME1'];
		   $L_AMT1            = $_REQUEST['L_AMT1'];
		   $L_QTY1            =	$_REQUEST['L_QTY1'];



		 /* The returnURL is the location where buyers return when a
			payment has been succesfully authorized.
			The cancelURL is the location buyers are sent to when they hit the
			cancel button during authorization of payment during the PayPal flow
			*/

		   $returnURL =urlencode($url.'/ReviewOrder.php?currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType);
		   $cancelURL =urlencode("$url/SetExpressCheckout.php?paymentType=$paymentType" );

		 /* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
           $itemamt = 0.00;
           $itemamt = $L_QTY0*$L_AMT0+$L_AMT1*$L_QTY1;
           $amt = 5.00+2.00+1.00+$itemamt;
           $maxamt= $amt+25.00;
           $nvpstr="";
		   
           /*
            * Setting up the Shipping address details
            */
//           $shiptoAddress = "&SHIPTONAME=$personName&SHIPTOSTREET=$SHIPTOSTREET&SHIPTOCITY=$SHIPTOCITY&SHIPTOSTATE=$SHIPTOSTATE&SHIPTOCOUNTRYCODE=$SHIPTOCOUNTRYCODE&SHIPTOZIP=$SHIPTOZIP";
		   $shiptoAddress = '';
		   $shiptoAddress .= "&SHIPTONAME=$personName";
		   $shiptoAddress .= "&SHIPTOSTREET=$SHIPTOSTREET";
		   $shiptoAddress .= "&SHIPTOCITY=$SHIPTOCITY";
		   $shiptoAddress .= "&SHIPTOSTATE=$SHIPTOSTATE";
		   $shiptoAddress .= "&SHIPTOCOUNTRYCODE=$SHIPTOCOUNTRYCODE";
		   $shiptoAddress .= "&SHIPTOZIP=$SHIPTOZIP";
           
//           $nvpstr = "&ADDRESSOVERRIDE=1$shiptoAddress&L_NAME0=".$L_NAME0."&L_NAME1=".$L_NAME1."&L_AMT0=".$L_AMT0."&L_AMT1=".$L_AMT1."&L_QTY0=".$L_QTY0."&L_QTY1=".$L_QTY1."&MAXAMT=".(string)$maxamt."&AMT=".(string)$amt."&ITEMAMT=".(string)$itemamt."&CALLBACKTIMEOUT=4&L_SHIPPINGOPTIONAMOUNT1=8.00&L_SHIPPINGOPTIONlABEL1=UPS Next Day Air&L_SHIPPINGOPTIONNAME1=UPS Air&L_SHIPPINGOPTIONISDEFAULT1=true&L_SHIPPINGOPTIONAMOUNT0=3.00&L_SHIPPINGOPTIONLABEL0=UPS Ground 7 Days&L_SHIPPINGOPTIONNAME0=Ground&L_SHIPPINGOPTIONISDEFAULT0=false&INSURANCEAMT=1.00&INSURANCEOPTIONOFFERED=true&CALLBACK=https://www.ppcallback.com/callback.pl&SHIPPINGAMT=8.00&SHIPDISCAMT=-3.00&TAXAMT=2.00&L_NUMBER0=1000&L_DESC0=Size: 8.8-oz&L_NUMBER1=10001&L_DESC1=Size: Two 24-piece boxes&L_ITEMWEIGHTVALUE1=0.5&L_ITEMWEIGHTUNIT1=lbs&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&PAYMENTACTION=".$paymentType;
		   
		   $nvpstr = '';
		   $nvpstr .= 
		   $nvpstr .= "&ADDRESSOVERRIDE=1$shiptoAddress";
		   $nvpstr .= "&L_NAME0=".$L_NAME0;
		   $nvpstr .= "&L_NAME1=".$L_NAME1;
		   $nvpstr .= "&L_AMT0=".$L_AMT0;
		   $nvpstr .= "&L_AMT1=".$L_AMT1;
		   $nvpstr .= "&L_QTY0=".$L_QTY0;
		   $nvpstr .= "&L_QTY1=".$L_QTY1;
		   $nvpstr .= "&MAXAMT=".(string)$maxamt;
		   $nvpstr .= "&AMT=".(string)$amt;
		   $nvpstr .= "&ITEMAMT=".(string)$itemamt;
		   $nvpstr .= "&CALLBACKTIMEOUT=4";
		   $nvpstr .= "&L_SHIPPINGOPTIONAMOUNT1=8.00";
		   $nvpstr .= "&L_SHIPPINGOPTIONlABEL1=UPS Next Day Air";
		   $nvpstr .= "&L_SHIPPINGOPTIONNAME1=UPS Air";
		   $nvpstr .= "&L_SHIPPINGOPTIONISDEFAULT1=true";
		   $nvpstr .= "&L_SHIPPINGOPTIONAMOUNT0=3.00";
		   $nvpstr .= "&L_SHIPPINGOPTIONLABEL0=UPS Ground 7 Days";
		   $nvpstr .= "&L_SHIPPINGOPTIONNAME0=Ground";
		   $nvpstr .= "&L_SHIPPINGOPTIONISDEFAULT0=false";
		   $nvpstr .= "&INSURANCEAMT=1.00";
		   $nvpstr .= "&INSURANCEOPTIONOFFERED=true";
		   $nvpstr .= "&CALLBACK=https://www.ppcallback.com/callback.pl";
		   $nvpstr .= "&SHIPPINGAMT=8.00";
		   $nvpstr .= "&SHIPDISCAMT=-3.00";
		   $nvpstr .= "&TAXAMT=2.00";
		   $nvpstr .= "&L_NUMBER0=1000";
		   $nvpstr .= "&L_DESC0=Size: 8.8-oz";
		   $nvpstr .= "&L_NUMBER1=10001";
		   $nvpstr .= "&L_DESC1=Size: Two 24-piece boxes";
		   $nvpstr .= "&L_ITEMWEIGHTVALUE1=0.5";
		   $nvpstr .= "&L_ITEMWEIGHTUNIT1=lbs";
		   $nvpstr .= "&ReturnUrl=".$returnURL;
		   $nvpstr .= "&CANCELURL=".$cancelURL;
		   $nvpstr .= "&CURRENCYCODE=".$currencyCodeType;
		   $nvpstr .= "&PAYMENTACTION=".$paymentType;
		   
           $nvpstr = $nvpHeader.$nvpstr;
           
		 	/* Make the call to PayPal to set the Express Checkout token
			If the API call succeded, then redirect the buyer to PayPal
			to begin to authorize payment.  If an error occured, show the
			resulting errors
			*/
		   $resArray=hash_call("SetExpressCheckout",$nvpstr);
		   $_SESSION['reshash']=$resArray;

		   $ack = strtoupper($resArray["ACK"]);

		   if($ack=="SUCCESS"){
					// Redirect to paypal.com here
					$token = urldecode($resArray["TOKEN"]);
					$payPalURL = PAYPAL_URL.$token;
					header("Location: ".$payPalURL);
				  } else  {
					 //Redirecting to APIError.php to display errors.
						$location = "APIError.php";
						header("Location: $location");
					}
} else {
		 /* At this point, the buyer has completed in authorizing payment
			at PayPal.  The script will now call PayPal with the details
			of the authorization, incuding any shipping information of the
			buyer.  Remember, the authorization is not a completed transaction
			at this state - the buyer still needs an additional step to finalize
			the transaction
			*/

		   $token =urlencode( $_REQUEST['token']);

		 /* Build a second API request to PayPal, using the token as the
			ID to get the details on the payment authorization
			*/
		   $nvpstr="&TOKEN=".$token;

		   $nvpstr = $nvpHeader.$nvpstr;
		 /* Make the API call and store the results in an array.  If the
			call was a success, show the authorization details, and provide
			an action to complete the payment.  If failed, show the error
			*/
		   $resArray=hash_call("GetExpressCheckoutDetails",$nvpstr);
		   $_SESSION['reshash']=$resArray;
		   $ack = strtoupper($resArray["ACK"]);

		   if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING'){
					require_once "GetExpressCheckoutDetails.php";
			  } else  {
				//Redirecting to APIError.php to display errors.
				$location = "APIError.php";
				header("Location: $location");
			  }
}
?>

	  
	  
	  <!-- InstanceEndEditable -->
	</div><!-- col1 -->
    <div class="col2">
      <!-- InstanceBeginEditable name="links" -->
	  links	  <!-- InstanceEndEditable -->	
      <div id="Title">
		Upcoming Events
	</div>
    <!-- #BeginLibraryItem "/Library/upcoming.lbi" -->
<strong><a href="http://atlcurling.wikia.com/wiki/Curling_Camp_2010">Curling Camp</a></strong><br/>
<i>July 31 - August 1</i><br/>
Atlanta Curling Club's first official activity! Come curling with us in Knoxville.  Includes two &quot;Learn to Curl&quot; sessions and two games of curling.
<!-- #EndLibraryItem --></div>
    <!-- col2 -->
  </div><!-- colleft -->
</div><!-- colmask -->
<div id="Footer">
    <p>
		<a href="index.php">Home</a> &nbsp; -- &nbsp; 
		<a href="aboutus.php">About Us</a> &nbsp; -- &nbsp; 
		<a href="joinus.php">Join Us</a> &nbsp; -- &nbsp; 
		<a href="payment.php">Payment</a> &nbsp; -- &nbsp; 
		<a href="schedule.php">Schedule</a> &nbsp; -- &nbsp; 
		<a href="http://bit.ly/atlcurling">Facebook</a> &nbsp; -- &nbsp; 
		<a href="http://atlcurling.wikia.com">Wiki</a> &nbsp; -- &nbsp; 
		<a href="contactus.php">Contact Us</a>
	</p>
	<p>Curl with us soon! Copyright &copy; 2010 Atlanta Curling Club, Inc., All Rights Reserved</p>
</div><!-- Footer -->
</div><!-- Page -->
</body>
<!-- InstanceEnd --></html>
