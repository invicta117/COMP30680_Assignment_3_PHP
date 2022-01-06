<?php
echo "<nav>";
$pages = array("index.php"=>"Home", "offices.php"=>"Offices", "payments.php"=>"Payments");
echo "<ul>";
foreach ($pages as $page=>$name){
    echo "<li>". "<a href=$page >$name</a>"."</li>";
}
echo "</ul>";   
echo "</nav>";
?>