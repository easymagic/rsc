<?php 
 
 require_once('engine_helpers/engine-config.php');
 require_once('engine_helpers/engine-db.php');

 extract($_REQUEST);
 // echo $__q__;
 
 if (!empty($__q__)){
  $_SERVER['PHP_SELF'] = $__q__;
  include($__q__);
 }else{
  $__q__ = 'index.php';	
  $_SERVER['PHP_SELF'] = $__q__;
  include($__q__);  
 }
 

