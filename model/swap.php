<?php
    
    class swap{
        
            static function getProductSwaps( $idProduct ){
                $data = dbGets("select *, u.id as user_id , s.id as swap_id ,product_id ,  from swap as s, users as u , product as p where id_product_swaped = $idProduct and id_product_offred=p.id and p.id_user=u.id and s.status != 'deleted'  order by swap_date");                
                return $data;
            }
  					
          
            static function getProductComments( $idProduct ){
                $data = dbGets("SELECT * FROM swap_comment as sp, user as us WHERE id_swap = $idSwap and type = 'comment' group by sp.id_user , us.id");
                    return $data;
            }
            
            
            static function getSwapComments( $idSwap ){
                $data = dbGets("SELECT * FROM swap_comment as sp, user as us WHERE id_swap = $idSwap and type='swap' group by sp.id_user , us.id");
                return $data;
            }         
       
            static function addSwapComment( $id_user , $id_swap , $comment ){
                $data = dbPost("INSERT INTO `swap_comment` (`id`, `comment`, `id_user`, `id_swap`, `type`, `comment_date`) VALUES (NULL, '$comment', '$id_user', '$id_swap', 'swap', now());");
            }
            
            
            static function addProductComment( $id_user , $id_swap , $comment ){
                $data = dbPost("INSERT INTO `swap_comment` (`id`, `comment`, `id_user`, `id_swap`, `type`, `comment_date`) VALUES (NULL, '$comment', '$id_user', '$id_swap', 'comment', now());");
            }
            
            static function addSwap( $idProduct , $id_user, $idProductOffred , $message  ){
                $data = dbPost("INSERT INTO `swap` (`id`, `message`, `id_product_swaped`, `id_product_offred`, `status`, `swap_date`) VALUES (NULL, '$message', '$idProduct', '$idProductOffred', 'pending', now() );");
                return $data;
            }
            
            static function deleteSwap( $idSwap ){
                $data = dbPost("UPDATE swap SET status = 'deleted' WHERE id = $idSwap");
                return $data;
            }
   
    }

?>