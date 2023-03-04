<?php
/* include file for all scripts */


/* runtime configuration  */
$app_config = array(
'database'       => 'value',
'dbase_username' => 'value'
);



/* 
   start session
   session variables:
   s_username     -> logged in username, if this is not set, no user logged in.
   state_variable -> important data to remember
	 xxx            -> description...
*/
session_start();



/* 
   initialization code
   create database connection, bootstrapping, etc.
*/





?>