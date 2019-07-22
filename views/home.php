<?php



$form = new Controlview($config, $phrases);
$form -> printIndex();

 /* session variable created for flash messaging - communicates to user file has been uploaded - this is unset every time page loads
/ This means the session variable is only present when a file is uploaded in submitform method in the controlview class. */
unset($_SESSION['upload-file']);
?>
