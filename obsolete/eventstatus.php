<?php

	require_once("settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('include.php');

// tkt0.2
	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

// lib
	require_once("DynHtmlPage.php");
	require_once("DynHtmlBlock.php");

	$pageName = "Events";

	DynHtmlPage::docHeader($pageName);


?>
<div class="colmask leftmenu">

  <?php DynHtmlPage::header(); ?>

  <div class="colleft">
    <div class="col1"> 
	  <!-- InstanceBeginEditable name="body" -->
	  
	  
	<?php

	$page = "login.php";
	require_once("{$TKTDIR}logic.eventstatus.php");

	?>
 
	  <!-- InstanceEndEditable -->
	</div><!-- col1 -->

	<?php DynHtmlPage::upcoming(); ?>
    </div><!-- col2 -->
  </div><!-- colleft -->
</div><!-- colmask -->

<?php

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();

?>
