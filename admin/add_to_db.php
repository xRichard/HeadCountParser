<?php

include('functions.inc.php');
$xmlUrl = "temp/test2.xml"; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);

//Making the database connection
db_connect();

//Make the general raid_key
$raid_key = mysql_real_escape_string($arrXml['key']);
$raid_key = timeparser($raid_key);

//counting the number of players
$number_players = count($arrXml['PlayerInfos']);

//check too make sure we don't get double attendancy data in the database 
//nobody likes double data :)
$check_raid_key_query = "SELECT *
    FROM `join`
    WHERE `raid_key` = '".$raid_key."';";
mysql_query($check_raid_key_query);
$check_raid_key = mysql_affected_rows();

if($check_raid_key > 0)
{
//This part still needs more code but we will stick with this for now :)

    echo "The raid key already exists - this is usually because you tried too upload old data again";
    echo "<br />";

}
//seems the database didn't contain any raidkeys so going too dump all the 
//crap into the database.
else
{


//Run the for loop
for($i = 1; $i <= $number_players; $i++)
{

    $player_name = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['name']);
    $player_race = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['race']);
    $player_guild = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['guild']);
    $player_sex = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['sex']);
    $player_class = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['class']);
    $player_level = mysql_real_escape_string($arrXml['PlayerInfos']['key'.$i]['level']);
    $query_playerinfo = "INSERT INTO `playerinfo` 
        (
            `player_name` ,
            `player_race` ,
            `player_guild` ,
            `player_sex` ,
            `player_class` ,
            `player_level`
        )
    VALUES 
        (
            '".$player_name."', 
            '".$player_race."', 
            '".$player_guild."', 
            '".$player_sex."', 
            '".$player_class."',
            '".$player_level."'
        );";
mysql_query($query_playerinfo);
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

mysql_query($query_bosskill);
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
mysql_query($query_attendees);

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
        $raid_zone = mysql_real_escape_string($arrXml['Join']['zone'];
        
        $query_joined = "INSERT INTO `join` (
        `player_name`,
        `join_time`,
        `raid_key`,
        `raid_zone`
        )
        values
        (
            '".$player_name."','".$join_time."','".$raid_key."','".$raid_zone."'
        );";
mysql_query($query_joined);
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

mysql_query($query_leave);
    }


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

        mysql_query($check_itemid_query);
        $check_itemid = mysql_affected_rows();
        var_dump($check_itemid);

        if($check_itemid == 0)
        {
            $add_item_query = "INSERT INTO `loot` (
                `itemname`,
                `itemid`,
                `icon`,
                `class`,
                `subclass`,
                `color`,
                `zone`,
                `boss`
            ) values (
                '".$itemname."', '".$itemid."', '".$icon."', '".$class."', '".$subclass."', '".$color."', '".$zone."', '".$boss."'
            );";
mysql_query($add_item_query);
        }
    }
}
?>
