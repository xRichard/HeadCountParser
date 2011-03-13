<?php
//Reading script - will read all the database and display it on the screen 
//this script will be used too show who shows and who got which loot during 
//raids. Seeing this is the only file we REALLY need for the read out part 
//we will just make it the index file as well ;)

//including the function file
include('functions.inc.php');

//building up the header
echo "<h1>HeadCount Parser</h1>";

//Making the database connection
db_connect();

//the first general query too show the first piece of data - the raid keys 
//which we will use too navigate at first.
$raid_key_query = "SELECT DISTINCT raid_key FROM `join`;";
$raid_key_data = mysql_query($raid_key_query);
$raid_key_count = mysql_num_rows($raid_key_data);

//The start screen which shows our raid keys + the instances that go with 
//it the moment i have found those ;)
echo "<pre>";
for($i = 1; $i <= $raid_key_count; $i++)
{
    $data = mysql_fetch_array($raid_key_data);
    print_r($data);
    echo "<br />";
}
echo "</pre>";
?>
