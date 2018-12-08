<?php
	/*
		- checkGetExist( ['name','pseudo'] )
			o return true if the key exist in $_GET
			
		- checkGetExistAndEqualTo( ['name' => 'ayoub' , 'pseudo' => 'takashi'] )          
			o return true if the keys exist in $_GET and $_GET['name'] == 'ayoub' and $_GET['pseudo'] == 'takashi'
			
		- checkGetExistAndNotNull( ['ayoub','marouan'] )
			o return true if ayoub != null ( &ayoub=&marouan=  : False )
	*/

	function checkGetExist($listArray){
		$cp = 0; $total = count($listArray);
		foreach($_GET as $item => $value){
			if( !in_array( $item , $listArray ) ){ continue; }
			$cp += 1;
		} 
		if($cp == $total){ return True; }
		return False;
	}

	function _checkGetExistDict($listArray){
		/* Compare Dict with key */
		$cp = 0; $total = count($listArray);
		foreach($_GET as $item => $value ){
			if( !array_key_exists( $item , $listArray ) ){ continue; }
			$cp += 1;
		} 
		if($cp == $total){ return True; }
		return False;
	}
	function checkGetExistAndEqualTo($listArray){
		if(_checkGetExistDict($listArray)){
			foreach($listArray as $item => $value){
				if( is_array($item) ){
					if( !in_array( $_GET[$item] , $item ) ) return False;
				}
				else{
					if($_GET[$item] != $value)
					return False;
				}
			} return True;
		} return False;
	}	

	function checkGetExistAndNotNull($listArray){
		if(checkGetExist($listArray)){
			foreach($listArray as $item){
				if( $_GET[$item] == null ){ return False; }
			} return True;
		} return False;
	}


	function dbSecureDict( $dict , $dictParameter ){
      	for( $parameter as $dictParameter ){
          	$dict[ $parameter ] = $dictParamter;
        }
    }

?>