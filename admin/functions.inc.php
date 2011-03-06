<?php
//admin gets a seperate functions + config file too make it easier for 
//everything and too make sure people don't get access too the parts where 
//they shouldn't be.
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

 //this function will parse the XML data into a nice big array
 function objectsIntoArray($arrObjData, $arrSkipIndices = array())
    {
         $arrData = array();
        if input is object, convert into array
        if (is_object($arrObjData)) 
            {
                 $arrObjData = get_object_vars($arrObjData);
             }
        if (is_array($arrObjData)) 
            {
                foreach ($arrObjData as $index => $value) 
                    {
                        if (is_object($value) || 
                        is_array($value)) 
                            {
                                $value = objectsIntoArray($value, 
                                $arrSkipIndices); // recursive call
                            }
                        if (in_array($index, 
                        $arrSkipIndices)) 
                            {
                                continue;
                            }
                        $arrData[$index] = $value;
                    }
            }
        return $arrData;
    }

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
?>
