<!DOCTYPE HTML> 
<html lang="en">  

<head>    
<meta charset="utf-8"> <!-- give character encoding https://www.w3schools.com/tags/att_meta_charset.asp -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- this comes from the w3 schools website https://www.w3schools.com/css/css_rwd_viewport.asp -->
<title>ClassicModels</title>
<link rel=stylesheet type="text/css" href="./mystyle.css">
<script defer src="./myscript.js"></script> 
</head>

<body>  
    

<?php include 'header.php';?>     <!-- from lecture 16 -->    
<h1>Payments</h1>


<div class="page"> 
<div class="tablescontainer">    
    
<?php
// this comes from practical P9 solutions, please change the localhost to your port number to run this on your machine    
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "classicmodels";


// Create connection
// try catch and function comes from lecture 17 and the provided examples
try {
    $conn = @mysqli_connect($servername, $username, $password, $dbname); // @ used to supress warnings for this function comes from
    //https://stackoverflow.com/questions/1987579/remove-warning-messages-in-php
    checkconn();
} 
catch(Exception $e ){
    echo "<h3>Hmm looks like you are having trouble connecting to our database <br/> Please contact us if this problem persists</h3>";
    echo "<p class='error'>This problem has occured when we could not connect to the database</p>";
}

function checkconn(){
    if(mysqli_connect_errno()){ // this comes from https://www.w3schools.com/php/func_mysqli_error.asp
        throw new Exception("cannot connect to database");
    }
}



function checkquery($result){
    if(!$result){ // again the idea for this comes from https://www.w3schools.com/php/func_mysqli_error.asp
        throw new Exception("query failed");
    }
}

$rows1 = [];  // initialize empty array so that if the data cannot be accessed we know because these arrays will be empty
$rows = [];

if ($conn){
    // this comes from practical P9 solutions
    $sql = "SELECT checkNumber, paymentDate, amount, customerNumber FROM payments Order By paymentDate DESC";
    $result1 = mysqli_query($conn, $sql);
    // try catch and function comes from lecture 17 and the provided examples
    try{
        checkquery($result1);
        if (mysqli_num_rows($result1) > 0) {
            while($row1 = mysqli_fetch_assoc($result1)) { // this comes from practical P9 solutions
                $rows1[] = $row1; //https://www.php.net/manual/en/mysqli-result.fetch-array.php
            }
            $first20 = array_slice($rows1, 0, 20);
            $totals = array();
            foreach($first20 as $f){
                $total = 0; // initialize to get the total payments for a customer
                foreach($rows1 as $r){
                    if ($f["customerNumber"] === $r["customerNumber"]){
                        $total += floatval($r["amount"]);
                    }
                }
                $totals[$f["customerNumber"]] = $total; //store total
            }   
        }
    }
    catch(Exception $e){
        echo "<h3>Cannot get Customer Payments info at this time</h3>";
        echo "<p class='error'>This problem has occured after connecting to our database and requesting customer payemnts info</p>";
    }
    // this comes from practical P9 solutions
    $sql2 = "SELECT customerNumber, phone, salesRepEmployeeNumber, creditLimit FROM customers";
    $result2 = mysqli_query($conn, $sql2);
    // try catch and function comes from lecture 17 and the provided examples
    try {
        checkquery($result2);
        if (mysqli_num_rows($result2) > 0) { // this comes from practical P9 solutions
            while($row2 = mysqli_fetch_assoc($result2)) {
                $rows[] = $row2; //https://www.php.net/manual/en/mysqli-result.fetch-array.php
            }
        }    
    }   
    catch(Exception $e){
        echo "<h3>Cannot get Customer info at this time</h3>";
        echo "<p class='error'>This problem has occured after connecting to our database and requesting customer info</p>";
    }
    mysqli_close($conn); // this comes from practical P9 solutions
    // close the connection, only done when we actually connect as otherwise we get a warning
}

if (count($rows1) > 0) {
    // output data of each row
    echo "<table class='maintable'>";
    echo "<tr>"."<th>" ."Check Number". "</th>". "<th>". "Payment Date". "</th>". "<th>". "Amount". "</th>". "<th>" ."Customer Number". "</th>". "</tr>";
    $i = 0; // allows us to only show the row clicked when there was multiple customers with the same number
    foreach($first20 as $row) {
        echo "<tr>";
        echo "<td>". $row["checkNumber"]."</td>"."<td>". $row["paymentDate"]. "</td>". "<td>" . $row["amount"]."</td>"."<td class='customerentry' onclick='rowdisplay(this,".$row["customerNumber"].$i." )'>". $row["customerNumber"]."</td>";
        echo "</tr>";

        echo "<tr class=' details ".$row["customerNumber"].$i."'><td colspan='4'>";
        if (count($rows) > 0){
            echo "<table class='customers'>";
            echo "<tr><th colspan='3'>Customer</th></tr>";
            echo "<tr>". "<th>". "Phone". "</th>". "<th>". "Sales Rep Employee Number". "</th>". "<th>" ."Credit Limit". "</th>". "</tr>";
        foreach($rows as $r){
            if ($row["customerNumber"] === $r["customerNumber"]){
                echo "<tr>";
                echo "<td>".$r["phone"]."</td>"."<td>". $r["salesRepEmployeeNumber"]."</td>"."<td>". $r["creditLimit"]."</td>";
                echo  "</tr>";
            }    
        }
        echo "</table>";
        } else {
            echo "<h3>Cannot get Customer info at this time</h3>";
        }
        echo "</td></tr>";


        // customer payments
        echo "<tr class=' details ".$row["customerNumber"].$i."'><td colspan='4'>";
        echo "<table class='payments'>";
        echo "<tr><th colspan='4'>Customer Payments</th></tr>";
        echo "<tr>"."<th>" ."Check Number". "</th>". "<th>". "Payment Date". "</th>". "<th>". "Customer Number". "</th>". "<th>" ."Amount". "</th>". "</tr>";
        foreach($rows1 as $r1){
            if ($row["customerNumber"] === $r1["customerNumber"]){
                echo "<tr>";
                echo "<td>". $r1["checkNumber"]."</td>"."<td>". $r1["paymentDate"]. "</td>"."<td>". $row["customerNumber"]."<td>" . $r1["amount"]."</td>"."</td>";
                echo  "</tr>";
            } 
        }
        echo "<tr class='total-row'><td colspan='3'>Total</td><td colspan='1'>".$totals[$row["customerNumber"]]."</td>"."</tr>";
        echo "</table>";
        echo "</td></tr>";
        $i++;
    }
    echo "</table>";
} else {
    echo "<h3>No data to display</h3>";
}



?>

</div>
</div>
<?php include 'footer.php';?>     <!-- from lecture 16 -->    
    
</body>  
</html>