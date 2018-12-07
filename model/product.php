<?
	/*
		loadProduct
		loadProductsUser
		loadProductsByCategory
		loadProductsBySearch
		loadProductsByNearMe
		addProduct
		addImages
		removeImage
		editProduct
		removeImage
		removeProduct
		editColumn
	*/
	
    <?

    class product{
        
        static function loadProduct( $id ){
            return dbGet("SELECT * FROM product WHERE id = $id");
        }
        
        static function loadProductsUser($idUser){ 
            return dbGets( "SELECT * FROM product WHERE id_user = $idUser" );
        }
        
        static function loadProductsByCategory( $cat ){
            return dbGets("SELECT * FROM product WHERE id_category = $cat");
        }
        
        static function loadProductsBySearch($search ,$id_category=0){
       $cat="";
       if($id_category!=0)
       $cat=" and id_category=$id_category ";
        return dbGets("select * from product where title like '%$search%' or description like '%$search%' $cat order by post_date ");
        }
        
        static function loadProductsByNearMe( $long , $lat ){
        $query="
            set @lat=$lat;
            set @lng=$long;
            SELECT *, 111.045 * DEGREES(ACOS(COS(RADIANS(@lat)) * COS(RADIANS(latitude)) *         COS(RADIANS(longtitude) - RADIANS(@lng)) + SIN(RADIANS(@lat)) * SIN(RADIANS(latitude)))) AS distance_in_km FROM product ORDER BY distance_in_km 
            ";
            return dbGets( $query );
        }
        
        static function addProduct($title,$description,$id_category,$value,$id_user,$id_ville,$long,$la,$list_photo){
            $added=dbPost("INSERT INTO `product` (`id`, `title`, `description`, `id_category`, `value`, `id_user`, `id_ville`, `longtitude`, `latitude`, `status`, `post_date`) VALUES (NULL, '$title', '$description', '$id_category', '$value', '$id_user', '$id_ville', '$long', '$la', 'pending', now())");     
           return dbGetId();
        }
      
        static function addImages( $idProduct , $list_paths ){
            for($list_paths as $path)
            dbPost("INSERT INTO `image` (`id`, `image`, `id_product`) VALUES (NULL, '$idProduct ', '$path');");
        }
        
        static function removeImage(  $idImage ){
            $qr = dbPost("DELETE FROM image WHERE id = $idImage ");
            return $qr;
        }
      
        static function editProduct( $id, $title,$description,$id_category,$value,$id_user,$id_ville, $status ){
            $edited = dbPost("UPDATE `product` SET `title` = '$title', `description` = '$description', `id_category` = '$id_cantegory', `value` = '$value', `id_user` = '$id_user', `id_ville` = '$id_ville', `status` = '$status' )";
        }
        
        static function removeImage( $idImage ){
            return dbPost( "DELETE From image WHERE id = '$idImage'  " );
        }
        
        static function removeProduct( $id ){
            return product::editColumn( $id , 'status' , 'removed' );
        }
                
        static function editColumn( $id , $champ , $val ){
            return dbPost("update product set $champ='$val' where id = $id ");
        }
        
    }

?>