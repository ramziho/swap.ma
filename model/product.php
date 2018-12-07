<?
	/*
		loadProduct
		addProduct
		addImages
		removeImage
		editProduct
		removeImage
		removeProduct
		editColumn
	*/
	
    class product{
        
        static function loadProduct( $id ){
            return $dbGet("SELECT * FROM product WHERE id = $id");
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