<?php

   class notification{
  		//  check your swaps or your comments in swaps
  		static function addProductSwapNotification( $productId ){
          return dbPost("INSERT INTO `notification` (`id`, `user_id`, `type`, `id_target`, `status`, `notification_date`) VALUES (NULL,".dbGet("select id_user from product where id=$productId").", 'swapRequest', $productId, 'active', now());");
      }
  		
  		static function addSwapAcceptedNotification( $swapId ){
          return dbPost("INSERT INTO `notification` (`id`, `user_id`, `type`, `id_target`, `status`, `notification_date`) VALUES (NULL,".dbGet("select id_user from swap as s, product as p  where id_product_offred=p.id and s.id=$swapId").", 'swapAccepted', ".dbGet("select id_product_swaped from swap where id=$swapId ").", 'active', now());");
      }
  		
  		static function addProductRejectedNotification( $productId ){
        return dbPost("INSERT INTO `notification` (`id`, `user_id`, `type`, `id_target`, `status`, `notification_date`) VALUES (NULL,".dbGet("select id_user from product where id=$productId").", 'productComment', $productId, 'active', now());");
      }
  		
  		static function addProductCommentNotification( $idUser , $productId ){
        return dbPost("INSERT INTO `notification` (`id`, `user_id`, `type`, `id_target`, `status`, `notification_date`) VALUES (NULL, $idUser , 'productComment', $productId, 'active', now());");
      }
  
  		static function addSwapCommentNotification(  $idUser , $productId ){
        return dbPost("INSERT INTO `notification` (`id`, `user_id`, `type`, `id_target`, `status`, `notification_date`) VALUES (NULL, $idUser , 'swapComment', $productId, 'active', now());");
      }
  
  		static function setNotificationViewed( $idsNotifications ){
        return dbPost("update notification set status='viewed' where id in (".implode(',',$idsNotifications).")");
      }
			
  		static function getNotificationsByUser( $idUser ){
         dbPost("DELETE FROM notification WHERE DATEDIFF(now(), notification_date) > 30 ");
         $data = dbGets("SELECT * FROM notification WHERE user_id = $idUser");
         return $data;
      }
		
	}

?>