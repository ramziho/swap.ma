<?php

	class user{

		function loadUser( $userId  ){
			return dbGets(" select * from users where id= $userId ");
		}

		function addUser( $userId , $email , $lastName, $firstName , $password ,  $pathPhoto , $tel   , $type ){
			$added=dbPost("insert into users values ( $userId,'$firstName','$lastName','$email','$password','$tel','$pathPhoto',now() , ‘$type' )"   );
			return $added;
		}
		
		function editUser( $userId  , $email , $lastName, $firstName , $password ,  $pathPhoto , $tel   , $type  ){
			$modified=dbPost("update users set first_name='$firstName', last_name='$lastName', email='$email', password='$password', tel='$tel', image_path='$pathPhoto' ,type= ‘$type'  where id=$userId " );
				return $modified;
		}

		function editChamp($id , $champ , $value){
			$modified=dbPost("update users set $champ='$value' where id=$id ");
			return $modified;
		}

	}

?>