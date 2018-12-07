<?php
/* 
	
	- dbGet("SELECT * FROM MEMBRE")
		return Dict of the table (only one result)
	
	- dbGets("SELECT * FROM MEMBRE")
		return Dict of the table (all result)
	
	-dbPost("UPDATE membre set name = 'Ayoub' ")
		return True if the request work and false if not. 
		
*/


// Connection au serveur MySql
$serveur='212.1.210.220';	//Nom du serveur (en local : locahost)
$user='eventelo_user';	//Nom de l'utilisateur (en local : root)
$mdp_='hahaha123';	//Mot de passe (en local : aucun)
$base='eventelo_swap';	//Nom de la base de données


@$connect=mysqli_connect($serveur, $user, $mdp_) or die ('Erreur : '.mysqli_error());
@mysqli_select_db($connect,$base) or die ('Erreur : '.mysqli_error());


function dbGet($request){
	$re = mysqli_query($GLOBALS['connect'],$request);
	$row = mysqli_fetch_array($re);
	return $row[0];
}

function dbGets($request){
	$re = mysqli_query($GLOBALS['connect'],$request);
	$result = array();
	while($data = mysqli_fetch_array($re) ) {
	  array_push( $result , $data );
	  // var_dump($data);
	}
	return $result;
}

function dbPost($request){
	$re = mysqli_query($GLOBALS['connect'],$request);
	return $re;
}

function dbSecure( $string ){
	$string = mysqli_real_escape_string( $string );
	return $string;
}

?>