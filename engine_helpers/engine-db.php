<?php 
 
 function db_get_connection(){
   static $connection = null;
   
   if ($connection == null){

		$connection = mysqli_connect(ENGINE_SERVER,
			                         ENGINE_USER,
			                         ENGINE_PASSWORD,
			                         ENGINE_DATASTORE);
		// If connection was not successful, handle the error
		if($connection === false) {
			die('Db Connection needs fix!');
		    // Handle error - notify administrator, log to a file, show an error screen, etc.
		}
   }
  
  return $connection;

 }

 
 function db_get($table,$where=array(),$comparator=' = ',$ordering='',$pagination=''){
	$rows = array();

	$where_clause = db_get_comparator($where,$comparator);

	if (!empty($ordering)){
      $ordering.= ' order by ' . $ordering;
	}

	if (!empty($pagination)){
      $pagination.= ' limit ' . $pagination;
	}

    $sql = "select * from $table $where_clause $ordering $pagination";
    $result = mysqli_query(db_get_connection(),$sql);
  

	if ($result === false){
	    // Handle failure - log the error, notify administrator, etc.
	}else{
	    // Fetch all the rows in an array
	    // $rows = array();
	    while ($row = mysqli_fetch_assoc($result)) {
	        $rows[] = $row;
	    }
	}

	return $rows;  
  
 }


 function db_clean_string($value){
   return mysqli_real_escape_string(db_get_connection(),$value);
 }

 function db_get_comparator($where,$comparator){
	
	$where_clause = array();
	if (count($where) > 0){
      foreach ($where as $k=>$v){
      	if ($comparator == 'like'){
          $deep_compare = '%';
      	}else{
          $deep_compare = '';
      	}
        $where_clause[] = " $k $comparator '$deep_compare" . db_clean_string($v) . "$deep_compare' "; 
      }

        $where_clause = ' where (' . implode(' and ', $where_clause) . ') ';
	}else{
		$where_clause = '';
	}

   return $where_clause;

 }

 function db_update($table,$data,$where=array(),$comparator = ' = '){
   
    $where_clause = db_get_comparator($where,$comparator);

	$invalues = array();
	foreach ($data as $k=>$v){
     $invalues[] = " $k = '" . db_clean_string($v) . "' ";
	}

	$invalues = implode(' , ', $invalues);

    $sql = "update $table set $invalues $where_clause ";
    $result = mysqli_query(db_get_connection(),$sql);


 }


 function db_create($table,$data){
   $keys = array_keys($data);
   $values = array_values($data);
   $values = array_map('db_clean_string', $values);


   $keys = ' (' . implode(',', $keys) . ') values (';

   $values = " ' " . implode(" ',' ", $values ) . " ' ) ";

   $sql = "insert into $table $keys $values"; 
   $result = mysqli_query(db_get_connection(),$sql);
   return mysqli_insert_id();
 }

 function db_delete($table,$where=array(),$comparator = ' = '){

   $where_clause = db_get_comparator($where,$comparator);
   
   $sql = "delete from $table $where_clause";
   $result = mysqli_query(db_get_connection(),$sql);
 
 }


