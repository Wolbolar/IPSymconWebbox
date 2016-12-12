<?
//*************************************************************************************************************
// Definieren der Konstanten für den Enigma-Receiver
global $k_DREAMBOXIP;
global $k_SAMSUNG;
global $k_WIFPORT;
global $k_DREAMBOX;

$k_DREAMBOXIP = GetValue(58413);
$k_SAMSUNG = GetValue(32110);
$k_WIFPORT = GetValue(42651);
$k_DREAMBOX = $k_DREAMBOXIP.":".$k_WIFPORT;

?>
