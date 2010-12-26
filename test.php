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

db_connect();

$number_players = count($arrXml['PlayerInfos']);

for($i = 1; $i <= $number_players; $i++)
{

    $player_name = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['name']);
    $player_race = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['race']);
    $player_guild = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['guild']);
    $player_sex = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['sex']);
    $player_class = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['class']);
    $player_level = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['level']);
    $query_playerinfo = "INSERT INTO playerinfo (
player_name ,
player_race ,
player_guild ,
player_sex ,
player_class ,
player_level
)
VALUES (
'".$player_name."', '".$player_race."', '".$player_guild."', '".$player_sex."', '".$player_class."','".$player_level."');";

//remove_this  mysql_query($query_playerinfo);
}
$number_bosskills = count($arrXml['BossKills']);
for($i = 1; $i <= $number_bosskills; $i++)
{
    $boss_name = mysql_real_escape_string($arrXml['BossKills']['key'.$i]['name']);
    $boss_time = mysql_real_escape_string($arrXml['BossKills']['key'.$i]['time']);
    $str = $boss_time;
    if (($timestamp = strtotime($boss_time)) === false)
        {
            echo "The string ($str) is bogus";
        }
    else
        {
            $boss_time = date('Y-m-d H:i:s', $timestamp);
        }

    $query_bosskill = "INSERT INTO bosskil (
    boss_name,
    boss_time
    )
    VALUES
    (
       '".$boss_name."', '".$boss_time."' 
    );";

//remove_this    mysql_query($query_bosskill);
    $boss_id = mysql_insert_id();
    $attendees = count($arrXml['BossKills']['key'.$i]['attendees']);
    for($a = 1; $a <= $attendees; $a++)
    {
        $attendee_name = $arrXml['BossKills']['key'.$i]['attendees']['key'.$a]['name'];
        $attendee_name = mysql_real_escape_string($attendee_name);
        $query_attendees = "INSERT INTO attendees (
        boss_id,
        player_name
        )
        VALUES
        (
           ".$boss_id.", '".$attendee_name."'
        );";
//remove_this        mysql_query($query_attendees);

    }  
}

//echo "<hr />";
echo "<pre>";
    //echo "Player info";
    //    print_r($arrXml['PlayerInfos']['key1']);
    //echo "<hr />";
    //echo "Boss kills";
    //    print_r($arrXml['BossKills']);
    //echo "<hr />";
    //echo "Notes";
    //    print_r($arrXml['note']);
    echo "<hr />";
    echo "Join";
        print_r($arrXml['Join']['key1']);
    echo "<hr />";
    echo "Leave";
        print_r($arrXml['Leave']['key1']);
    echo "<hr />";
    echo "Loot";
        print_r($arrXml['Loot']['key10']);
echo "</pre>";

?>