<!DOCTYPE HTML> 
<html lang="en">  

<head>    
<meta charset="utf-8"> <!-- give character encoding https://www.w3schools.com/tags/att_meta_charset.asp -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- this comes from the w3 schools website https://www.w3schools.com/css/css_rwd_viewport.asp -->
<title>ClassicModels</title>
<link rel=stylesheet type="text/css" href="./mystyle.css">
<script defer src="./myscript.js"></script> <!-- this comes from https://www.w3schools.com/tags/att_script_src.asp-->
</head>

<body>  

<?php include 'header.php';?>     <!-- from lecture 16 -->    
<h1>Product Lines</h1>
<?php
// this comes from practical P9 solutions, please change the localhost to your port number to run this on your machine    
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "classicmodels";

function checkconn(){
    if(mysqli_connect_errno()){ // this comes from https://www.w3schools.com/php/func_mysqli_error.asp
        throw new Exception("cannot connect to database");
    }
}
// try catch and function comes from lecture 17 and the provided examples
try {
    // this comes from practical P9 solutions
    $conn = @mysqli_connect($servername, $username, $password, $dbname); // @ used to supress warnings for this function when can't connect comes from
    //https://stackoverflow.com/questions/1987579/remove-warning-messages-in-php
    checkconn();
} 
catch(Exception $e ){
    echo "<h3>Hmm looks like you are having trouble connecting to our database <br/> Please contact us if this problem persists</h3>";
    echo "<p class='error'>This problem has occured when we could not connect to the database</p>";
}


function checkquery($result){
    if(!$result){ // again the idea for this comes from https://www.w3schools.com/php/func_mysqli_error.asp
        throw new Exception("query failed");
    }
}


$rows1 = []; // initialize empty array so that if the data cannot be accessed we know because these arrays will be empty
$rows2 = [];

if ($conn){ // this was done to skip the queries to the database when a connection could not be made
    
    // this comes from practical P9 solutions
    $sql1 = "SELECT productLine, textDescription FROM productlines";
    $result1 = mysqli_query($conn, $sql1);
    // try catch and function comes from lecture 17 and the provided examples
    try{
        checkquery($result1);
        // when connection is made store the results in an array
        if (mysqli_num_rows($result1) > 0) { // this comes from practical P9 solutions
            while($row1 = mysqli_fetch_assoc($result1)) {
                $rows1[] = $row1; //https://www.php.net/manual/en/mysqli-result.fetch-array.php
            }
        }
    }
    catch(Exception $e){
        echo "<h3>Cannot get Product Line info at this time</h3>";
        echo "<p class='error'>This problem has occured after connecting to our database and requesting productline info</p>";
    }
    
    // this comes from practical P9 solutions
    $sql2 = "SELECT p.* FROM products as p, productlines as pl WHERE p.productLine = pl.productLine";
    $result2 = mysqli_query($conn, $sql2);
    // try catch and function comes from lecture 17 and the provided examples
    try {
        checkquery($result2);
        if (mysqli_num_rows($result2) > 0) { // this comes from practical P9 solutions
            while($row2 = mysqli_fetch_assoc($result2)) {
                $rows2[] = $row2; //https://www.php.net/manual/en/mysqli-result.fetch-array.php
            }
        }
    }
    catch(Exception $e){
        echo "<h3>Cannot get Individual Product Info at this time</h3>";
        echo "<p class='error'>This problem has occured after connecting to our database and requesting individual product info</p>";
    }    
    mysqli_close($conn); // this comes from practical P9 solutions
    // close the connection, only done when we actually connect as otherwise we get a warning

}

$colhead = array("Product Code", "Product Name", "Product Line", "Product Scale", "Product Vendor", "Product Description", "Quantity In Stock", "Buy Price", "MSRP");
$cols = array("productCode", "productName", "productLine", "productScale", "productVendor", "productDescription", "quantityInStock", "buyPrice", "MSRP");
    
if (count($rows1) > 0) {
    // output data of each row
    foreach($rows1 as $row) {
        echo "<div class='page'>";
        echo "<div class='line'>";
        echo "<h2>".$row["productLine"]."</h2>";
        echo "<p>".$row["textDescription"]."</p>";

        if (count($rows2) > 0) {
            echo "<table class='listing'>";
            echo "<tr><th colspan='9'>Products in Line</th></tr>";
            echo "<tr>";
            foreach($colhead as $ch){ // create the table headers
                echo "<th>". $ch."</th>";    
            }
            echo "</tr>";
            foreach($rows2 as $r){
                if ($r["productLine"] === $row["productLine"]){
                    echo "<tr>";
                    foreach($cols as $c){
                        echo "<td>". $r[$c]."</td>";    // create the data for the table
                    }
                    echo "</tr>";
                }
            }
        echo "</table>";
        } else {
            echo "<h3 class='listing'>Cannot get Individual Product Info</h3>"; // if there is no individual product listing data avaliable
            // for example if there was a query failure
        }
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<h3>No data to display</h3>";
}

?>

    
<?php include 'footer.php';?>  <!-- from lecture 16 -->    
    

</body>  
</html>