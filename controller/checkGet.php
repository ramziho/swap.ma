<?php
	/*
		- checkGetExist( ['name','pseudo'] )
			o return true if the key exist in $_GET
			
		- checkGetExistAndEqualTo( ['name' => 'ayoub' , 'pseudo' => 'takashi'] )          
			o return true if the keys exist in $_GET and $_GET['name'] == 'ayoub' and $_GET['pseudo'] == 'takashi'
			
		- checkGetExistAndNotNull( ['ayoub','marouan'] )
			o return true if ayoub != null ( &ayoub=&marouan=  : False )
	*/

	function checkDictExist( $dict , $listArray ){
		$cp = 0; $total = count($listArray);
		foreach($dict as $item => $value){
			if( !in_array( $item , $listArray ) ){ continue; }
			$cp += 1;
		} 
		if($cp == $total){ return True; }
		return False;
	}

	
	function _checkGetExistDict($dict,$listArray){

		/* Compare Dict with key */
		$cp = 0; $total = count($listArray);
		foreach($dict as $item => $value ){
			if( !array_key_exists( $item , $listArray ) ){ continue; }
			$cp += 1;
		} 
		if($cp == $total){ return True; }
		return False;
	}
	

	function checkGetExistAndEqualTo($dict,$listArray){
		if(_checkGetExistDict($dict,$listArray)){
			foreach($listArray as $item => $value){
				if( is_array($item) ){
					if( !in_array( $dict[$item] , $item ) ) return False;
				}
				else{
					if($dict[$item] != $value)
					return False;
				}
			} return True;
		} return False;
	}	

	
	function checkGetExistAndNotNull($dict,$listArray){
		if(checkGetExist($dict,$listArray)){
			foreach($listArray as $item){
				if( $dict[$item] == null ){ return False; }
			} return True;
		} return False;
	}

	function dbSecureDict( $dict , $dictParameter ){
      	for( $parameter as $dictParameter ){
          	$dict[ $parameter ] = $dictParamter;
        }
    }

?>