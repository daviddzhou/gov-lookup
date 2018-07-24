<?php
	/*Connects to the server with the server location, login credentials, and Database name
	or prints and error message */ 

		$db = mysqli_connect('localhost','id1712109_nathanpak','npak1234','id1712109_apgov')
		or die('Error connecting to MySQL server.'.'<script type="text/javascript">
           window.location = "usreps.000webhost.com/eastereggs/error.html"');



?>



<?php
	/*Pulls the user input from the html of the previous page and inputs it into the variable $ZipCode
	Technically should also help prevent against SQL Injection however requires testing to validate this */

		$ZipCode= mysqli_real_escape_string($db, $_REQUEST['ZipCode']);
?>

 

<?php

if ($ZipCode == "404") {
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://usreps.000webhostapp.com/eastereggs/error.html\">";
            }
?>

<?php
if ($ZipCode == "apgov2016")
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://usreps.000webhostapp.com/eastereggs/apgov2016.html\">";
            }

?>

<?php
if ($ZipCode == "senioritis")
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://usreps.000webhostapp.com/eastereggs/trex.html\">";
            }

?>


<?php

if ($ZipCode == "version1")
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://usreps.000webhostapp.com/Supporting%20Documents/test.html\">";
            }
?>


<html>
    
        <link rel="stylesheet" href="styles.css">
<head><title>Representative Data</title></head>
    
<div class="box">
	<h1>Representatives by Zip Code</h1>
 
		<body>

 
 
			<?php
				/*Prints out the entered ZipCode, useful for user verification as well as debugging to check that variables and input
				are correctly being stored */
					echo "<font size = +1>The entered Zip Code is: </font>" . $ZipCode;
			?>


			<br/>
			<br/>



			<?php
				/*Creates the Query command variable that the program will run later, should enter the $ZipCode variable from earlier however may have issues here
				Also could be susceptible to SQL Injection but will require testing*/
 
					$query = "SELECT * FROM ZIPDATA WHERE zip = '$ZipCode'";

				/*Queries the SQL Server for the given query statement*/

					$result = mysqli_query($db, $query);
					
					$row = mysqli_fetch_array($result);
					
					/*
				Puts the queried value for ABDR into a new PHP Variable for use in the NameData table 
				Also prints out the state abbreviation and district combination for debugging temporarily
				*/

					$SADN = $row['ABDR'];
					
					$SA = $row['stateabbr'];

			
			?>

            
            
            
			<!--PHP Function that if the zip exists will allow for the query to display-->
			
            
			<?php 
				if($SADN==true )
					{ 
			?>
 
            
            

			<?php

				/*Creates the Query command variable that the program will run later, should enter the $SADN variable from earlier
				Also could be susceptible to SQL Injection but will require testing*/
 
					$query2 = "SELECT * FROM NAMEDATA WHERE `115 St/Dis` IN (SELECT ABDR FROM ZIPDATA WHERE zip = '$ZipCode')";

				/*Queries the SQL Server for the given query statement*/

					$result2 = mysqli_query($db, $query2);

				/*Gives specific error messages for problems with the query*/

					if (!$result2) {
					printf("Error: %s\n", mysqli_error($db));
					exit();
					}

				/*Creates row variable that can be used to split up the specified query in the actual printing
				(I think, this is one part of this I don't fully understand, need to check for accuracy of above statement)*/

					$row2 = mysqli_fetch_array($result2);

				/*Prints the specified NAMEDATA Rows, could be expanded in the future to let the user choose what information
				to be displayed.  */

					echo"<hr/>";
                    echo"<br/>";
                    echo "<font size = +1>The Representative for your district is: <br/>",
					$row2['FirstName'] . ' ' . $row2['MiddleName'] . ' '. $row2['LastName'] . ' ' . $row2['Suffix'] . ' (' . $row2['Party'] . ')' .'<br/>';
                   
			?>
			
			<br/>
			
<!-- Trigger/Open The Modal -->
<button id="btn1">Committee Assignments</button>			

<!-- The Modal -->
<div id="comrep" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Committee Assignments</h2>
    </div>
    <div class="modal-body">
      
	  <?php  
	  echo $row2['Committee Assignments'];  
	  ?>
      
    </div>
  </div>

</div>


<script>
// Get the modal
var modal = document.getElementById("comrep");

// Get the button that opens the modal
var btn = document.getElementById("btn1");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}


</script>





<!-- Trigger/Open The Modal -->
<button id="btn2">Contact Information</button>			

<!-- The Modal -->
<div id="con" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close2">&times;</span>
      <h2>Contact Information</h2>
    </div>
    <div class="modal-body">
      
	  <?php  
        echo 'Address: ' .  $row2['Concatenated Address'];
        echo "<br/>";
        echo ' Phone Number: ' . $row2['Phone'];  
	  ?>
      
    </div>
  </div>

</div>


<script>
// Get the modal
var modal2 = document.getElementById('con');

// Get the button that opens the modal
var btn2 = document.getElementById("btn2");

// Get the <span> element that closes the modal
var span2 = document.getElementsByClassName("close2")[0];

// When the user clicks the button, open the modal 
btn2.onclick = function() {
    modal2.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
    modal2.style.display = "none";
}


</script>

			
    <br/>
    <hr/>	
			
			
			
			
			<?php
				/*Same as above just for senators and reps*/
				
						$query3 = "SELECT * FROM SENGOV WHERE `State` IN (SELECT stateabbr FROM ZIPDATA WHERE zip = '$ZipCode')";
						
						$result3 = mysqli_query($db, $query3);
						
						if (!$result3) {
						printf("Error: %s\n", mysqli_error($db));
						exit();
						}
						
						

						$row3 = mysqli_fetch_array($result3);

						
						echo "<br/>";
						echo "<font size = +1>The Junior Senator for the state of $SA is:</font> ";
						echo "<br/>";
						
						echo $row3['Junior Senator'] .  ' <br/><br/>'; 
                     
                    ?>
            
            <!-- Trigger/Open The Modal -->
<button id="btn3">Committee Assignments</button>			

<!-- The Modal -->
<div id="comsen" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close3">&times;</span>
      <h2>Committee Assignments</h2>
    </div>
    <div class="modal-body">
        
	  <?php  
	  echo $row3['committe assn1']; 
    
	  ?>
      
    </div>
  </div>

</div>


<script>
// Get the modal
var modal3 = document.getElementById('comsen');

// Get the button that opens the modal
var btn3 = document.getElementById("btn3");

// Get the <span> element that closes the modal
var span3 = document.getElementsByClassName("close3")[0];

// When the user clicks the button, open the modal 
btn3.onclick = function() {
    modal3.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span3.onclick = function() {
    modal3.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
}
</script>





<!-- Trigger/Open The Modal -->
<button id="btn4">Contact Information</button>			

<!-- The Modal -->
<div id="sencon" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close4">&times;</span>
      <h2>Contact Information</h2>
    </div>
    <div class="modal-body">
      
	  <?php  
        echo 'Address: ' .  $row3['address1'];
        echo "<br/>";
        echo ' Phone Number: ' . $row3['phone1']; 
        echo "<br/>";
        echo 'Email: ' . $row3['email1'];
	  ?>
      
    </div>
  </div>

</div>


<script>
// Get the modal
var modal4 = document.getElementById('sencon');

// Get the button that opens the modal
var btn4 = document.getElementById("btn4");

// Get the <span> element that closes the modal
var span4 = document.getElementsByClassName("close4")[0];

// When the user clicks the button, open the modal 
btn4.onclick = function() {
    modal4.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span4.onclick = function() {
    modal4.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal4) {
        modal4.style.display = "none";
    }
}
</script>

			
			<hr/>
            <?php
                    
                  
						echo"<br/>";
						echo "<font size = +1>The Senior Senator for the state of $SA is:</font>";
						echo "<br/>";
				
                    
                    
						echo $row3['Senior Senator'] . ' <br/><br/>';
                    
                    
                    
                    
                    ?>
            
         
<!-- Trigger/Open The Modal -->
<button id="btn5">Committee Assignments</button>			

<!-- The Modal -->
<div id="comsen2" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close5">&times;</span>
      <h2>Committee Assignments</h2>
    </div>
    <div class="modal-body">
      
	  <?php  
	  echo $row3['committe assn2'];  
	  ?>
      
    </div>
  </div>

</div>


<script>
// Get the modal
var modal5 = document.getElementById('comsen2');

// Get the button that opens the modal
var btn5 = document.getElementById("btn5");

// Get the <span> element that closes the modal
var span5 = document.getElementsByClassName("close5")[0];

// When the user clicks the button, open the modal 
btn5.onclick = function() {
    modal5.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span5.onclick = function() {
    modal5.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal5) {
        modal5.style.display = "none";
    }
}
</script>





<!-- Trigger/Open The Modal -->
<button id="btn6">Contact Information</button>			

<!-- The Modal -->
<div id="consen2" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close6">&times;</span>
      <h2>Contact Information</h2>
    </div>
    <div class="modal-body">
      
	  <?php  
	  echo 'Address: ' .  $row3['address2'];
        echo "<br/>";
      echo ' Phone Number: ' . $row3['phone2'];
        echo "<br/>";
        echo 'Website: ' . $row3['website2']
	  ?>
      
    </div>
  </div>

</div>


<script>
// Get the modal
var modal6 = document.getElementById('consen2');

// Get the button that opens the modal
var btn6 = document.getElementById("btn6");

// Get the <span> element that closes the modal
var span6 = document.getElementsByClassName("close6")[0];

// When the user clicks the button, open the modal 
btn6.onclick = function() {
    modal6.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span6.onclick = function() {
    modal6.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal6) {
        modal6.style.display = "none";
    }
}
</script>

			<hr/>


		   
            <?php
						echo"<br/>";
						echo "<font size = +1>The Governor for the state of $SA is:</font>";
				echo "<br/>";
						
						echo $row3['Governor'] . ' <br/><br/>';
                   
			?>

  





<!-- Trigger/Open The Modal -->
<button id="btn7">Contact Information</button>			

<!-- The Modal -->
<div id="gov" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close7">&times;</span>
      <h2>Contact Information</h2>
    </div>
    <div class="modal-body">
      
	  <?php  
	  echo 'Address: ' .  $row3['Address3'];
        echo "<br/>";
      echo ' Phone Number: ' . $row3['phone3'];  
	  ?>
      
    </div>
  </div>

</div>


<script>
// Get the modal
var modal7 = document.getElementById('gov');

// Get the button that opens the modal
var btn7 = document.getElementById("btn7");

// Get the <span> element that closes the modal
var span7 = document.getElementsByClassName("close7")[0];

// When the user clicks the button, open the modal 
btn7.onclick = function() {
    modal7.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span7.onclick = function() {
    modal7.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal7) {
        modal7.style.display = "none";
    }
}
</script>

	<hr/>

			<?php
				/* Closes connection with the server to keep it from a constant pull */

					mysqli_close($db);

				?>
			<br/>


			

			
			<?php 
				}
			?>
			
		</-- PHP function that if there is an incorrect zip code entered will dispay this version of the webpage-->
			
			<?php 
				if ($SADN==False) 
					{ 
			?>
			
				<p> The entered Zip Code is not a valid Zip Code</p>
				

			<?php
				} 
			?>
			
<form action="/sources.html" method = "post">
			
			<input type="submit" value="Sources" onClick="return empty()" >
        </form>
<br/>



		<!--Creates a go back button to return to previous page -->
				
			<button onclick="goBack()">Go Back</button>
 
			<script>
				function goBack() {
				window.history.back();
				}
			</script>


			
<br/>
<br/>
			

		</body>

</div>
</html>