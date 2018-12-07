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
$base='eventelo_pandastones';	//Nom de la base de données


@$connect=mysql_connect($serveur, $user, $mdp_) or die ('Erreur : '.mysql_error());
@mysql_select_db($base) or die ('Erreur : '.mysql_error());


function dbGet($request){
	$re = mysql_query($request);
	$row = mysql_fetch_array($re);
	return $row;
}

function dbGets($request){
	$re = mysql_query($request);
	$result = array();
	while($data = mysql_fetch_array($re) ) {
	  array_push( $result , $data );
	  // var_dump($data);
	}
	return $result;
}

function dbPost($request){
	$re = mysql_query($request);
	return $re;
}

function dbSecure( $string ){
	$string = mysql_real_escape_string( $string );
	return $string;
}

?>