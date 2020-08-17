<?php

?>
<?php if(count($this->paginator) && !empty($this->paginator)){
          foreach($this->paginator as $item){ ?>
						<a data-url="<?php echo $item->photo_id; ?>" class="sesgroupalbum_corresponding_image_album" href="<?php echo Engine_Api::_()->sesgroupalbum()->getHrefPhoto($item->photo_id,$item->album_id); ?>">
            	<img src="<?php echo $item->getPhotoUrl('thumb.icon','','string'); ?>"/>
            </a>		
   <?php  }
}

 ?>