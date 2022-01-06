This readme outlines how I satisfies each of the requirements outlines in the assignments

NOTE: For XAMPP SQL to run on my laptop I had to change the localhost to localhost:3307 in each of the php files included to run this on another 
installitaion of XAMPP please change this to your port number for SQL.

The overall site navigation and footer for each page are included in the files header.php which contains the page navigation bar and the footer.php which contains
the footer for each page. These are referenced on all pages of the site.

index.php
This page contains info on each of the product lines, the entire div is clickable and highlights when the mouse moves over them to show that the can be
clicked. When clicked the full listing for each of the products in that range are displayed with all of their information. Only one of these sections displaying
all info for that line are able to be viewed at a time.

offices.php
This page shows all the offices for the company in a table. Address line 1 and line 2 are combined and output as just address. Since city was seperate to address
I did not include state, country etc. Each office also has a more info button when pressed displays info about the employees that work there, employees are
grouped by job title. The employee table is colored red to avoid confusion when looking at the table what data belongs to what. More than one empployee table
can be displayed at a time to as this was not specified in the assignment.

payments.php
This page displays the 20 most recent payments by payment date in a table. The customeer number table highlights when a user hovers over the numbers to indicate
it is clickable. When the user clicks on this cell in the table details on the customer is displayed in a red table as well as all payments by that customer and the total amount
for all their payments in a green table. The total amount is displayed at the bottom of the table.

Error handling
When a database connection fails, for example when the mysql database is turned off each of the pages responds in a similar way, an error message is displayed to 
the user saying that the page was not able to connect to the database (I assumed that most people would know a database is important for the data on the page)
as well as telling the user where the error occured, which was when trying to connect to the database as well as a message saying no data to display so that
all users would know something happened. 
In the index.php file when a query to get the product line info fails a warning message appears and I decided not to include
any data since all data in the products table depends on the output of the product lines. When the products cannot be reached because of a failed query, the product lines 
are shown and a message saying that the products cannot be gotten at the moment appears when the user clicks for more information on the product lines.
For the offices.php file similarly when a query fails for the offices table there is a message to tell the user that the data cannot be reached and no data is displayed
I chose this as the employees depend on the office location so there was no point in displaying them in a random order or grouped together if there was no info on the
office itself. If there is a query failure accessing the employee table, the offices are displayed but when the user clicks for more info there is a warning saying the data
is not available at the moment.
Lastly for the payments page when a query fails for the payments I decided not to show any data including data on the customers as there was no way of knowing who the most recent
payments were so the data on customers would not have anything to compare with. When there was a failure for the query accessing the customers table the rest of the payments were displayed
as well as the total but a warning was shown when the user looks for more info on the customer.
