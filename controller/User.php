<?php
  
   class User{
  
        function static initSession(){ if( !isset(session_id) ) session_start();  }

        function static isConnected(){
          user::initSession();
          if( isset($_SESSION['userID']) ) return true;
          return false;
        }

        function static setConnectedUser( $idUser ){
            user:initSession();
            $_SESSION['userId'] = $idUser; 
        }

        function static logout(){
            user::initSession();
            session_destroy();
        }

        function static register() {
          if( user::isConncted ) return array('response'=>'userIsAlreadyRegistred');
          //check all fields are presented
          if( ! checkDictExistAndNotNull($_POST, ['first_name','last_name','email','password','tel' ] ) ) return array('response'=>'failed','message'=>'veuillez remplir tout les champs');
          // secure parameter
          dbSecureDict( $_POST , ['first_name','last_name','email','password','tel'] );
          // check email format
          if(!checkContraintEmail($email))return array('response'=>'failed','message'=>"veuillez respecter format d'email" );
          // check length tel == 10 and not string
          if(!strlen($_POST['tel']==10 or  !ctype_digit($_POST['tel'])) return array('response'=>'failed','message'=>"veuillez respecter format de telephone " );
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
          		user::setConnectedUser( dbGetLast() ); 
              return array('response'=>'success','message'=>"bien inscrit" );           
          }
        	
        }

      function static login(){
        	if( user::isConncted ) return true;
          dbSecureDict( $_POST , [ 'email' , 'password' ] );
          if( checkGetExistAndNotNull( [ 'email' , 'password'] ) ){
              if( ! dbGet("SELECT * FROM users WHERE email = '$email' and password = '$password' ") ) return false;
            	user::setConnectedUser( dbGetLast() );
              return true;
          } return false;
      }
      
	}

?>