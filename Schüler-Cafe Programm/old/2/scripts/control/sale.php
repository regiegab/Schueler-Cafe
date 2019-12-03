<?php
echo "opened_Sale<br>";
// here you can add controls for the sale

// muss hiervor jetzt auch nochmal überprüft werden, ob die Benutzerdaten richtig eingegeben wurden? Sonst könnte ja jeder bei GET bzw. POST einfach z.B. ?action=open_sale&sale=buy reinschreiben, obwohl er garnicht können dürfte
// controls for the shop template(s)
switch($input['sale']){
//z.B.
case "buy":
  // buy sth.
  echo "sale_buy";
break;
default:
}

?>
