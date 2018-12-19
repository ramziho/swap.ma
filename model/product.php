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
	

    class product{
        
        static function loadProduct( $id ){
            return dbGet("SELECT * FROM product WHERE id = $id");
        }
        
        static function loadProductsUser($idUser ,$index,$total){
            return dbGets( "SELECT * FROM product WHERE id_user = $idUser limit $index , $total ");
        }
        
        static function loadProductsByCategory( $cat ,$id_ville ,$index,$total){
			$sql="and id_ville=$id_ville";
			if($id_ville==-1)$sql="";
			
            return dbGets("SELECT * FROM product a WHERE id_category = $cat $sql limit $index , $total ");
        }
        
        static function loadProductsBySearch($search,$id_ville ,$index,$total ,$id_category=0){
           $cat="";
           if($id_category!=0)
           $cat=" and id_category=$id_category ";
			$sql="and id_ville=$id_ville";
			if($id_ville==-1)$sql="";
            return dbGets("select * from product where title like '%$search%' or description like '%$search%' $cat $sql order by post_date limit $index , $total ");
        }
        static function loadProductsByFeed($id_ville ,$index,$total){
            $sql="and id_ville=$id_ville";
			if($id_ville==-1)$sql="";
    	return dbGets("select * , count(comment) as feed from products as p , swap_comment as c where c.type='comment' and p.id=c.id_swap $sql group by p.id order by feed limit $index , $total ");
    }
        static function loadProductsByNearMe( $long , $lat ,$index,$total,$id_category=0){
			$cat="";
           if($id_category!=0)
           $cat=" where id_category=$id_category ";
        $query="
            set @lat=$lat;
            set @lng=$long;
            SELECT *, 111.045 * DEGREES(ACOS(COS(RADIANS(@lat)) * COS(RADIANS(latitude)) *         COS(RADIANS(longtitude) - RADIANS(@lng)) + SIN(RADIANS(@lat)) * SIN(RADIANS(latitude)))) AS distance_in_km FROM product $cat ORDER BY distance_in_km  limit $index , $total ";
            
            return dbGets( $query );
        }
        
        static function addProduct($title,$description,$id_category,$value,$id_user,$id_ville,$long,$la,$list_photo){
            $added=dbPost("INSERT INTO `product` (`id`, `title`, `description`, `id_category`, `value`, `id_user`, `id_ville`, `longtitude`, `latitude`, `status`, `post_date`) VALUES (NULL, '$title', '$description', '$id_category', '$value', '$id_user', '$id_ville', '$long', '$la', 'pending', now())");     
			if( $added ) return dbGetId();
		    return false;
        }
      
        static function getProductPhotos( $idProduct ){
          $data = dbGets("SELECT * FROM photo WHERE id_product = $idProduct ");
          return $data;
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
   			
        static function getProductSwapAccepeted( $idProduct ){
          return dbGet("select id from swap where id_product_swaped=$idProduct and status='accepted' ");
        }
                             
        static function isAvailable( $idProduct ){
          	return dbGet("SELECT status FROM product WHERE id = ") == 'swapAccepted'; 
        }
                             
    }

?> 