<?php 
 
 session_start(); 
 // print_r($_SESSION);

 define('ENGINE_SERVER','localhost');
 define('ENGINE_USER','ewomencl_newchat');
 define('ENGINE_PASSWORD','P@ssword12.@');
 define('ENGINE_DATASTORE','ewomencl_webchat');


// $hostname_conn = "localhost";
// $database_conn = "ewomencl_webchat";
// $username_conn = "ewomencl_newchat";
// $password_conn = "P@ssword12.@";


/// gateway interfaces
interface iUseCase{
	function get_input($input);
	function get_ouptut();
	function exec();
	function has_access();
}

interface iRoute{
	function get_uri($uri);
	function get_output();
	function get_params($params);
	function exec();
	function has_access();
}

