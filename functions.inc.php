<?php
//Functions file - This file will contain the most basic functions like the 
//database connection, time parse scripts, etc.
//It will also contain the configs like host info, database info, guild 
//name, etc. So this file will do it's work as both the config file and as 
//the functions file :)

function db_connect()
    {
        //Database info
        $dbuser = 'root'; //mysql username
        $dbpass = 'p@ssw0rd'; //mysql password
        $dbserver = 'localhost'; //mysql server (usually localhost)
        $dbdatabase = 'raidtracker'; //mysql database in where the data is stored on the MySQL server
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
?>
