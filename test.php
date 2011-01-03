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

/*
 LootArray
(
    [ItemName] => Kilt of Untreated Wounds
    [ItemID] => 50990
    [Icon] => inv_pants_cloth_34purple
    [Class] => Armor
    [SubClass] => Cloth
    [Color] => ffa335ee
    [Count] => 1
    [Player] => Aierus
    [Costs] => 0
    [Time] => 03/17/10 15:55:21
    [Zone] => Icecrown Citadel
    [Boss] => Festergut
    [Note] => Array
        (
        )

)

*/

$count_loot = count($arrXml['Loot']);

for($i = 1; $i <= $count_loot; $i++)
    {
        $itemname = mysql_real_escape_string($arrXml['Loot']['key'.$i]['ItemName']);
        $itemid = mysql_real_escape_string($arrXml['Loot']['key'.$i]['ItemID']);
        $icon = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Icon']);
        $class = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Class']);
        $subclass = mysql_real_escape_string($arrXml['Loot']['key'.$i]['SubClass']);
        $color = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Color']);
        $count = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Count']);
        $player = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Player']);
        $costs = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Costs']);
        $time = timeparser($arrXml['Loot']['key'.$i]['Time']);
        $zone = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Zone']);
        $boss = mysql_real_escape_string($arrXml['Loot']['key'.$i]['Boss']);

        $check_itemid_query = "SELECT itemid FROM loot WHERE itemid = '".$itemid."';";
        $check_itemid = mysql_num_rows(mysql_query($check_itemid_query));
        if($check_itemid == 0)
        {
            $add_item_query("STILL_NEED_TO_ADD");
        }
        
    }

//echo "<hr />";
echo "<pre>";
    echo "<hr />";
    echo "Loot";
        print_r($arrXml['Loot']['key10']);
echo "</pre>";

?>