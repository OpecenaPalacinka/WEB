<?php

// nactu vlastni nastaveni webu
require_once("settings.inc.php");

// nactu tridu spoustejici aplikaci
require_once("ApplicationStart.class.php");

// spustim aplikaci
$app = new ApplicationStart();
$app->appStart();

?>
