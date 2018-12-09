<?php

	class user{

		static function loadUser( $userId  ){
			return dbGets(" select * from users where id= $userId ");
		}

		static function addUser( $userId , $email , $lastName, $firstName , $password ,  $pathPhoto , $tel   , $type ){
			$added=dbPost("insert into users values ( $userId,'$firstName','$lastName','$email','$password','$tel','$pathPhoto',now() , ‘$type' )"   );
			return $added;
		}
		
		static function editUser( $userId  , $email , $lastName, $firstName , $password ,  $pathPhoto , $tel   , $type  ){
			$modified=dbPost("update users set first_name='$firstName', last_name='$lastName', email='$email', password='$password', tel='$tel', image_path='$pathPhoto' ,type= ‘$type'  where id=$userId " );
				return $modified;
		}

		static function editChamp($id , $champ , $value){
			$modified = dbPost("update users set $champ='$value' where id=$id ");
			return $modified;
		}
		static function checkMailUser($email){
            return !(dbGet("select email from users where email='$email' ")==$email);
        }
	}

?>