<?php


function db_connect()
     {
    //Database info
$dbuser         =       'root';                     //mysql username
$dbpass         =       'p@ssw0rd';                 //mysql password
$dbserver       =       'localhost';                //mysql server (usually localhost)
$dbdatabase     =       'raidtracker';              //mysql database in where the data is stored on the MySQL server
     //set connection var
     $con = mysql_connect($dbserver, $dbuser, $dbpass);
     //Check if connection works if not return error
         if (!$con)
             {
                 die('Could not connect: ' . mysql_error());
             }
         //Connection works
         else
            {
        //Select database
        $db_selected = mysql_select_db($dbdatabase, $con);
         //check if selected database exists, if not return error.
                     if (!$db_selected)
                         {
                             die ('Can\'t use '.$database.' : ' . mysql_error());
                         }
             }
     }

//This function will parse the XML data into a nice big array
function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
   
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
   
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}

$xmlUrl = "test2.xml"; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);

//Making the database connection
db_connect();


function timeparser($time)
{
   if (($timestamp = strtotime($time)) === false)
        {
            echo "The string ($time) is bogus";
            exit();
        }
    else
        {
            return date('Y-m-d H:i:s', $timestamp);
        } 
}

//Make the general raid_key
$raid_key = mysql_real_escape_string($arrXml['key']);
$raid_key = timeparser($raid_key);

//counting the number of players
$number_players = count($arrXml['PlayerInfos']);
//Run the for loop
for($i = 1; $i <= $number_players; $i++)
{

    $player_name = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['name']);
    $player_race = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['race']);
    $player_guild = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['guild']);
    $player_sex = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['sex']);
    $player_class = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['class']);
    $player_level = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['level']);
    $query_playerinfo = "INSERT INTO `playerinfo` (
`player_name` ,
`player_race` ,
`player_guild` ,
`player_sex` ,
`player_class` ,
`player_level`
)
VALUES (
'".$player_name."', '".$player_race."', '".$player_guild."', '".$player_sex."', '".$player_class."','".$player_level."');";

//remove_this  mysql_query($query_playerinfo);
}

//Count the amount of bosses killed
$number_bosskills = count($arrXml['BossKills']);
//Run the for loop
for($i = 1; $i <= $number_bosskills; $i++)
{
    $boss_name = mysql_real_escape_string($arrXml['BossKills']['key'.$i]['name']);
    $boss_time = mysql_real_escape_string($arrXml['BossKills']['key'.$i]['time']);
    
    $boss_time = timeparser($boss_time);

    $query_bosskill = "INSERT INTO `bosskil` (
    `boss_name`,
    `boss_time`,
    `raid_key`
    )
    VALUES
    (
       '".$boss_name."', '".$boss_time."', '".$raid_key."'
    );";

//remove_this    mysql_query($query_bosskill);
    $boss_id = mysql_insert_id();
    $attendees = count($arrXml['BossKills']['key'.$i]['attendees']);
    for($a = 1; $a <= $attendees; $a++)
    {
        $attendee_name = $arrXml['BossKills']['key'.$i]['attendees']['key'.$a]['name'];
        $attendee_name = mysql_real_escape_string($attendee_name);
        $query_attendees = "INSERT INTO `attendees` (
        `boss_id`,
        `player_name`,
        `raid_key`
        )
        VALUES
        (
           ".$boss_id.", '".$attendee_name."', '".$raid_key."'
        );";
//remove_this        mysql_query($query_attendees);

    }  
}

//count for the join loop
$count_joined = count($arrXml['Join']);
//Join for loop
for($i = 1; $i <= $count_joined; $i++)
    {
        $player_name = mysql_real_escape_string($arrXml['Join']['key'.$i]['player']);
        $join_time = mysql_real_escape_string($arrXml['Join']['key'.$i]['time']);
        $join_time = timeparser($join_time);
        
        $query_joined = "INSERT INTO `join` (
        `player_name`,
        `join_time`,
        `raid_key`
        )
        values
        (
            '".$player_name."','".$join_time."','".$raid_key."'
        );";
//remove_this    mysql_query($query_joined);
    }

//Count leave
$count_leave = count($arrXml['Leave']);
//Leave for loop
for($i = 1; $i <= $count_leave; $i++)
    {
        $player_name = mysql_real_escape_string($arrXml['Leave']['key'.$i]['player']);
        $leave_time = mysql_real_escape_string($arrXml['Leave']['key'.$i]['player']);
        $leave_time = timeparser($join_time);
        
        $query_leave = "INSERT INTO `leave` (
            `player_name`,
            `leave_time`,
            `raid_key`
        )
        values
        (
            '".$player_name."', '".$leave_time."','".$raid_key."'
        );";

//remove_this   mysql_query($query_leave);
    }

//echo "<hr />";
echo "<pre>";
    echo "<hr />";
    echo "Loot";
        print_r($arrXml['Loot']['key10']);
echo "</pre>";

?>