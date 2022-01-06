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

<h1>Offices</h1> 
<div class="page"> 
<div class="tablescontainer"> 
<table class="maintable">  


<?php
// this comes from practical P9 solutions, please change the localhost to your port number to run this on your machine    
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "classicmodels";
// Create connection
// try catch and function comes from lecture 17 and the provided examples
try {
    // this comes from practical P9 solutions
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

$rows1 = [];
$rows2 = [];

if ($conn){ // this was done to skip the queries to the database when a connection could not be made
    // this comes from practical P9 solutions
    $sql1 = "SELECT officeCode, city, addressLine1, addressLine2, phone, officeCode FROM offices";
    $result1 = mysqli_query($conn, $sql1);
    // try catch and function comes from lecture 17 and the provided examples
    try{
        checkquery($result1);
        // when connection is made store the results in an array
        if (mysqli_num_rows($result1) > 0) {
            while($row1 = mysqli_fetch_assoc($result1)) {
                $rows1[] = $row1; //https://www.php.net/manual/en/mysqli-result.fetch-array.php
            }
        }
    }
    catch(Exception $e){
        echo "<h3>Cannot get Offices info at this time</h3>";
        echo "<p class='error'>This problem has occured after connecting to our database and requesting office info</p>";
    }
    // this comes from practical P9 solutions
    $sql2 = "SELECT o.officeCode, e.employeeNumber, e.lastName, e.firstName, e.jobTitle, e.email FROM offices as o, employees as e WHERE o.officeCode = e.officeCode ORDER BY o.officeCode";
    $result2 = mysqli_query($conn, $sql2);
    try {
        checkquery($result2);
        if (mysqli_num_rows($result2) > 0) {
            while($row2 = mysqli_fetch_assoc($result2)) {
                $rows2[] = $row2; //https://www.php.net/manual/en/mysqli-result.fetch-array.php
            }
        }
    }
    catch(Exception $e){
        echo "<h3>Cannot get Individual Employee Info at this time</h3>";
        echo "<p class='error'>This problem has occured after connecting to our database and requesting employee info</p>";
    }
        
    mysqli_close($conn); // this comes from practical P9 solutions
    // close the connection, only done when we actually connect as otherwise we get a warning
}

$empdet = array("Full Name", "Job Title", "Employee Number", "Email");
if (count($rows1) > 0) {
    // output data of each row
    echo "<tr>"."<th>" ."City". "</th>". "<th>". "Address". "</th>". "<th>". "Phone". "</th>". "<th>" ."More Info". "</th>". "</tr>";
    
    foreach($rows1 as $row) {
        echo "<tr>";
        echo "<td>". $row["city"]."</td>"."<td>". $row["addressLine1"]. " " . $row["addressLine2"]."</td>"."<td>". $row["phone"]."</td>"."<td>"."<button onclick='rowdisplay(this, ".$row["officeCode"].")' class='button'>More Info</button>"."</td>";
        echo "</tr>";
        echo "<tr class=' details " .$row["officeCode"]."'> <td colspan='4'>";
        if (count($rows2)> 0){
            echo "<table class='innertable'>";
            echo "<tr><th colspan='4'>Employees</th></tr>";
            echo "<tr>";
                foreach($empdet as $ed){
                    echo "<th>". $ed. "</th>";
            }
            echo "</tr>";
            foreach($rows2 as $r){
                if ($row["officeCode"] === $r["officeCode"]){
                    echo "<tr>";
                    echo "<td>".$r["firstName"]." ". $r["lastName"]."</td>"."<td>". $r["jobTitle"]."</td>"."<td>". $r["employeeNumber"]."</td>"."<td>". $r["email"]."</td>";
                    echo  "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "<h3>Cannot get Individual Employee Info at this time</h3>";
        }
        echo "</td> </tr>";
    }

} else {
    echo "<h3>No data to display</h3>";
}
?>
</table>  
</div>
</div>
<?php include 'footer.php';?>     <!-- from lecture 16 -->    
    
</body>  
</html>