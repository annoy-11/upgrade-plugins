<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesytube/externals/scripts/jquery.flex-images.js');?>
<div class="sesbasic_bxs sesytube_photos_wrapper">
	<ul class="sesytube_photos">
    <?php foreach($this->results as $result) { ?>
      <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
      <?php 
          $imageURL = $result->getPhotoUrl('thumb.normalmain');
          if(strpos($imageURL,'http://') === FALSE && strpos($imageURL,'https://') === FALSE) {
            if(strpos($imageURL,',') === false)   
              $imageGetSizeURL = $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . $imageURL;    
            else            
              $imageGrtSizeURL = $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . substr($imageURL, 0, strpos($imageURL, "?"));
          }
          else
          	$imageGetSizeURL = $imageURL;
          
    			$imageHeightWidthData = getimagesize($imageGetSizeURL);           
          $width = isset($imageHeightWidthData[0]) ? $imageHeightWidthData[0] : '300';
          $height = isset($imageHeightWidthData[1]) ? $imageHeightWidthData[1] : '200';
      ?>
      <li class="item" data-w="<?php echo $width; ?>" data-h="<?php echo $height; ?>">
        <a href="<?php echo $result->getHref(); ?>" class="_img"><img src="<?php $this->layout()->staticBaseUrl; ?>application/modules/Sesytube/externals/images/blank.gif" data-src="<?php echo $result->getPhotoUrl(); ?>"></a>
        <?php if($this->show_criteria) { ?>
          <p class="_cont">
            <?php if(isset($this->show_criteria) && in_array('by', $this->show_criteria)) { ?>
              <span class="_stats">
                <span> <?php echo $this->translate("By "); ?><a href="<?php echo $user->getHref(); ?>" class="thumbs_author"><?php echo $user->getTitle(); ?></a> </span>
              </span>
            <?php } ?>
            <span class="_stats">
              <?php if(isset($this->show_criteria) && in_array('like', $this->show_criteria)) { ?>
                <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $result->like_count), $this->locale()->toNumber($result->like_count)) ?>"> <i class="fa fa-thumbs-up"></i> <?php echo $result->like_count; ?> </span>
              <?php } ?>
              <?php if(in_array('comment', $this->show_criteria)) { ?>
              <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)) ?>"> <i class="fa fa-comment"></i> <?php echo $result->comment_count; ?> </span>
              <?php } ?>
              <?php if(in_array('view', $this->show_criteria)) { ?>
              <span title="<?php echo $this->translate(array('%s View', '%s Views', $result->view_count), $this->locale()->toNumber($result->view_count)) ?>"> <i class="fa fa-eye"></i> <?php echo $result->view_count; ?> </span>
              <?php } ?>
              <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum') && in_array('favouriteCount', $this->show_criteria)) { ?>
                <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $result->favourite_count), $this->locale()->toNumber($result->favourite_count)) ?>"> <i class="fa fa-heart"></i> <?php echo $result->favourite_count; ?> </span>
              <?php } ?>
            </span>
          </p>
        <?php } ?>
      </li>
    <?php } ?>
	</ul>
</div>

<script>
	sesJqueryObject('.sesytube_photos').flexImages({rowHeight: 250, truncate: true});
 </script>
