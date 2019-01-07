<?php
  
class Product{
  
  static function addProduct(){
    
    // response : 'missingParameter'
    if( !checkDictExistAndNotNull( $_POST , [ 'title' , 'description' , 'id_category' , 'value' , 'id_user' , 'id_ville' , 'long' , 'la' , 'list_photo'] ) ) return { 'response' : 'missingParameter' };
    
    // all data is good!
    dbSecureDict( $_POST ,  [ 'title' , 'description' , 'id_category' , 'value' , 'id_user' , 'id_ville' , 'long' , 'la' , 'list_photo' ] );
    
    // check Constrant
    if( ! checkDictContraint( $_POST , ['title' => 'text' , 'description' => 'text' , 'id_category' => 'int' , 'id_ville' => 'int' , 'long' => 'float' , 'la' => 'float'] )  ) return { 'response' : 'hacker' };
     	  
    $idProduct = product:addProduct( $title , $description , $id_category , $value , $id_user , $id_ville , $long , $la , $list_photo );

    if( ! $idProduct ) return [ "response" => "tryLater"];
  	
    // save images
    $path = [];
    for( $list_photo as $img ){
      $response = Product::uploadImage( $img );
      if( $response ) return [ "response" => "tryLater" ];
      array_push( $path , $response['path'] );
    }
    
    // save to database
    product:addImages( $idProduct , $path );

    return { 'response' => 'ok'};
  	
  } 
  
  static function getProductByFeed(){
    	// response : 'missingParameter'
    if( !checkDictExistAndNotNull( $_GET , [ 'index' , 'total' ,'id_ville'] ) ) return { 'response' : 'missingParameter' };
    
    // all data is good!
    dbSecureDict( $_GET , [ 'index' , 'total' ,'id_ville'] );
    
    // check Constrant
    if( ! checkDictContraint( $_GET ,[ 'index'=>'int' , 'total' => 'int','id_ville'=>'int' ]  )  ) return { 'response' : 'hacker' };
    $id_ville=$_GET['id_ville'];
    $index=$_GET['index'];
    $total=$_GET['total'];
   return product::loadProductsByFeed($id_ville,$index,$total);
  }
  
   static function getProductBySearch(){
    	// response : 'missingParameter'
    if( !checkDictExistAndNotNull( $_GET , [ 'index' , 'total' ,'id_ville','search'] ) ) return { 'response' : 'missingParameter' };
    
    // all data is good!
    dbSecureDict( $_GET , [ 'index' , 'total' ,'id_ville','search'] );
    
    // check Constrant
    if( ! checkDictContraint( $_GET ,[ 'index'=>'int' , 'total' => 'int','id_ville'=>'int' ]  )  ) return { 'response' : 'hacker' };
    $id_ville=$_GET['id_ville'];
    $index=$_GET['index'];
    $total=$_GET['total'];
    $search=$_GET['search'];
     $idCategory=0;
     if( checkDictExistAndNotNull( $_GET , [ 'idCategory' ] and checkDictContraint( $_GET ,[ 'idCategory'=>'int' ])
    		$idCategory=$_GET['idCategory'];
   return product::loadProductsBySearch($search,$id_ville,$index,$total,$idCategory);
  }
  
   static function getProductByCategory(){
    // response : 'missingParameter'
    if( !checkDictExistAndNotNull( $_GET , [ 'index' , 'total','idCategory'] ) ) return { 'response' : 'missingParameter' };
    
    // all data is good!
    dbSecureDict( $_GET , [ 'index' , 'total','idCategory' ] );
    
    // check Constrant
    if( ! checkDictContraint( $_GET ,[ 'index'=>'int' , 'total'=>'int' ,'idCategory'=>'int']  )  ) return { 'response' : 'hacker' };
    $index=$_GET['index'];
    $total=$_GET['total'];
    $idCategory=0;
     if( checkDictExistAndNotNull( $_GET , [ 'idCategory' ] and checkDictContraint( $_GET ,[ 'idCategory'=>'int' ])
    		$idCategory=$_GET['idCategory'];
    	return product::loadProductsByCategory($idCategory,$id_ville ,$index,$total );
  }
  
  static function getProductByNearMe(){
		// response : 'missingParameter'
    if( !checkDictExistAndNotNull( $_GET , [ 'index' , 'total','long','lat'] ) ) return { 'response' : 'missingParameter' };
    
    // all data is good!
    dbSecureDict( $_GET , [ 'index' , 'total' ,'id_ville','long','lat'] );
    
    // check Constrant
    if( ! checkDictContraint( $_GET ,[ 'index'=>'int' , 'total' => 'int','id_ville'=>'int' ,'long'=>'float','lat'=>'float']  )  ) return { 'response' : 'hacker' };
    $id_ville=$_GET['id_ville'];
    $index=$_GET['index'];
    $total=$_GET['total'];
    $lat=$_GET['lat'];
    $long=$_GET['long'];
    
   return product::loadProductsByFeed($long,$lat,$index,$total);
  }
  
  // load a user product
  static function loadUserProduct(){
     	$data = []
    	$products = product::loadProductsUser( User::getUserID()  );
  		for( $product as $products ){
        	array_push( $data , array_merge( $product , product::getProductPhotos( $produit['id'] ) );
      }
    	return $data;
  }

  // load a product for page profil
  static function loadProduct(){
    
  	  if( ! checkDictExsitAndNotNull( $_GET , ['id'] )  ) return false;
    	if( ! checkDictContraint( $_GET , [ 'id' => 'int' ] ) ) return false;
    	
    	dbSecure( $_GET , ['id'] );
    	
    	$product = product::loadProduct( $_GET['id'] );
    	if( ! $product ) return false;
    	
    	# data good
    	return array_merge(  $product ,  product::getProductPhotos( $_GET['id'] )   );
  
  }
  
  static function removeProduct(){
    	// response : 'missingParameter'
    if( !checkDictExistAndNotNull( $_POST , [ 'idProduct'  ] ) ) return { 'response' : 'missingParameter' }
    
    // all data is good!
    dbSecureDict( $_POST , [ 'idProduct' ] );
    
    // check Constrant
    if( ! checkDictContraint( $_POST ,[ 'idProduct'=>'int'  ]  )  ) return { 'response' : 'hacker' };
    $idProduct=$_POST['idProduct'];
    $id2=dbGet('select id_user from product where id=$idProduct ');
    $id=User::getUserID();
    if($id==$id2)
      return product::removeProduct($idProduct);
    	return false;
  }
  
  static function uploadImage( $name ){

        $path =  uniqid();			
        $target_dir = "/img/product/";
        $target_file = $target_dir . basename($_FILES[$name]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $target_file=$target_dir.$path.$imageFileType

        // check if there's file or not
        if ($_FILES[ $name ]['size'] == 0 && $_FILES['cover_image']['error'] == 0)
          return array( 'responese' => 'empty' , 'path' => '' );

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES[$name]["tmp_name"]);
        if($check !== false) {         
            $uploadOk = 1;
        } else {
            return array('response'=>'notImage','path'=>'');
        }

        // Check file size
        if ($_FILES[$name]["size"] > 500000) {
            return array('response'=>'large','path'=>'');
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            return array('response'=>'notAllowedType','path'=>'');
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return array('response'=>'notUpload','path'=>'');

        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
                return array('response'=>'OK','path'=>$target_file);
            } else {
               return array('response'=>'error uploading','path'=>$target_file);
            }
         }
    }
             
             
}
 
  ?>