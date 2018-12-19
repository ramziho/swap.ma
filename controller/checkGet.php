<?php
	/*
		- checkDictExist( ['name','pseudo'] )
			o return true if the key exist in $_GET
			
		- checkDictExistAndEqualTo( ['name' => 'ayoub' , 'pseudo' => 'takashi'] )          
			o return true if the keys exist in $_GET and $_GET['name'] == 'ayoub' and $_GET['pseudo'] == 'takashi'
			
		- checkDictExistAndNotNull( ['ayoub','marouan'] )
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

	
	function _checkDictExistDict($dict,$listArray){

		/* Compare Dict with key */
		$cp = 0; $total = count($listArray);
		foreach($dict as $item => $value ){
			if( !array_key_exists( $item , $listArray ) ){ continue; }
			$cp += 1;
		} 
		if($cp == $total){ return True; }
		return False;
	}
	

	function checkDictExistAndEqualTo($dict,$listArray){
		if(_checkDictExistDict($dict,$listArray)){
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

	
	function checkDictExistAndNotNull($dict,$listArray){
		if(checkDictExist($dict,$listArray)){
			foreach($listArray as $item){
				if( $dict[$item] == null ){ return False; }
			} return True;
		} return False;
	}

	function dbSecureDict( $dict , $dictParameter ){
      	for( $dictParameter as $parameter ){
          	$dict[ $parameter ] = dbSecure($dictParamter);
        }
    }
	
	function checkContraintEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	function checkContraintLength($word,$length){
		return strlen($word)>=$length;
	}
	function checkContraintInt($word){
		
		
		return filter_var($word, FILTER_VALIDATE_INT);
	}
	
	function checkContraintFloat($word){
		

		$floatVal = floatval($word);
	
		if($floatVal && intval($floatVal) != $floatVal)
{
    return true;
}
	return false;
	}
	function checkDictContraint($dict,$listArray){
//  int , float , email , tel , 
  if(checkDictExist($dict,$listArray)){
			foreach($listArray as $item => $v){
        if($v=='int'){
          if(!checkContraintInt($item)
             return false;
             }
          else if($v=='email'){
            if(!checkContraintEmail($item))
            return false
          }
             else if($v=='float'){
            if(!checkContraintFloat($item))
            return false
          }
             else if($v=='tel'){
         if(!strlen($item)==10 or  !ctype_digit($item) or !substr( $item, 0, 1) === "0")
             return false;
             }
        
        
   
    
             }}
             return true;
             }       
	
?>