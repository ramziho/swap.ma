<?php
  
   class User{
  
        function static initSession(){ if( !isset(session_id) ) session_start();  }

        function static isConnected(){
          User::initSession();
          if( isset($_SESSION['UserID']) ) return true;
          return false;
        }

        function static setConnectedUser( $idUser ){
            User::initSession();
            $_SESSION['UserId'] = $idUser; 
        }

        function static logout(){
            User::initSession();
            session_destroy();
        }
		
		function static getUserID(){
			return $_SESSION['UserId'];
		}

        function static register() {
          if( User::isConncted ) return array('response'=>'UserIsAlreadyRegistred');
          //check all fields are presented
          if( ! checkDictExistAndNotNull($_POST, ['first_name','last_name','email','password','tel' ] ) ) return array('response'=>'failed','message'=>'veuillez remplir tout les champs');
          // secure parameter
          dbSecureDict( $_POST , ['first_name','last_name','email','password','tel'] );
          // check email format
          if(!checkContraintEmail($email))return array('response'=>'failed','message'=>"veuillez respecter format d'email" );
          // check length tel == 10 and not string
          if(!strlen($_POST['tel'])==10 or  !ctype_digit($_POST['tel']) or !substr( $$_POST['tel'], 0, 1) === "0") return array('response'=>'failed','message'=>"veuillez respecter format de telephone " );
          //check passord minim 6 chars
          if(!checkContraintLength($_POST['password'],6))return array('response'=>'failed','message'=>"minimum 6 caracters" );
          // check email existe
          if(!checkMailUser($_POST['email'])) return array('response'=>'failed','message'=>'cet email deja inscrit');
          // check first name lenght
          if(!checkContraintLength($_POST['first_name'],3))return array('response'=>'failed','message'=>"minimum 3 caracters" );
          // check last name lenght
          if(!checkContraintLength($_POST['last_name'],3))return array('response'=>'failed','message'=>"minimum 3 caracters" );

          //register done
          if (addUser( 'NULL', $_POST['email'] , $_POST['last_name'], $_POST['first_name'] , $_POST['password'] ,  '' , $_POST['tel']   , '1' )){
          		User::setConnectedUser( dbGetLast() ); 
              return array('response'=>'success','message'=>"bien inscrit" );           
          }
        	
        }

      function static login(){
        	if( User::isConncted ) return true;
          dbSecureDict( $_POST , [ 'email' , 'password' ] );
          if( checkGetExistAndNotNull( [ 'email' , 'password'] ) ){
              if( ! dbGet("SELECT * FROM Users WHERE email = '$email' and password = '$password' ") ) return false;
            	User::setConnectedUser( dbGetLast() );
              return true;
          } return false;
      }
      
	}

?>