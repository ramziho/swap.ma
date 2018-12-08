<?php
  
    class  category{
        
  		static function getMainCategory(){
          	$data = dbGets("SELECT * from main_category");
          return $data;
        }
    		
  			static function getCatogories( $idMainCategory ){
           $data = dbGets("SELECT * FROM category WHERE id_main_category = $idMainCategory  "); 
           return $data;
        }
  	
    }

?>