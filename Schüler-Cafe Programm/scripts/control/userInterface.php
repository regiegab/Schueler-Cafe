<?php
// mein Vorschlag får eine Struktur får die einzelnen Funktionen wäre in etwas so:
// im template!!! "template.userInterface" rufts du bei bestimmten events(, falls z.B. auf irgendetwas draufgeklickt wird) index.php?action=open_userInterface&userInterface=dieFunktiondieduaufrufenwilst

//dann ein
switch ($input['userInterface']) {
  case 'dassWasDuObenHinterDasIstgleichBeiUserInterfaceGeschriebenHast':
    // code...
    // und dann alles am besten in einzelne Funktionen auslagern
    sampleFunction();
    break;

  default:
    // code...
}

function sampleFunction(){
  // code...
}

?>
