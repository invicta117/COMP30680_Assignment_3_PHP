<?php
echo "<footer>";
$pages = array("index.php"=>"Home", "offices.php"=>"Offices", "payments.php"=>"Payments");
echo "<ul class='footer-left'>";
foreach ($pages as $page=>$name){
    echo "<li>". "<a href=$page >$name</a>"."</li>";
}
echo "</ul>";

echo "<ul class='footer-right'>";
echo "<li>"."Website Design: John Doe"."</li>";
echo "<li>"."Email: johndoe@fict.mail"."</li>";
echo "<li>"."Tel: 000 0000 0000"."</li>";
echo "</ul>";

echo "</footer>";
?>