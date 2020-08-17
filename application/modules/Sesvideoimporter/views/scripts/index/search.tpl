<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: search.tpl 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesvideoimporter/externals/styles/styles.css'); ?>
<div class="sesbasic_clearfix sesimp_page_container">
<div class="sesimp_search sesbasic_bxs">
	<?php echo $this->form->render($this); ?>
</div>
<?php if (count($this->videoFeed) > 0){?>
    <div class="sesimp_listing sesbasic_clearfix sesbasic_bxs">
        <?php
        foreach($this->videoFeed as $key => $videoEntry):
            $videoID = $videoEntry['id'];
            $imageurl = $videoEntry['url'];
            ?>
            <div class="sesimp_listing_item">
            	<div class="sesimp_listing_item_inner sesbm">
              <?php if(!$imageurl){ 
                  $imageurl = "https://img.youtube.com/vi/$videoID/default.jpg";
               } ?>
                <div class="sesimp_listing_item_thumb sesbasic_clearfix">
                  <a href="<?php echo $this->url(array('action' => 'play', 'vid' => $videoID), 'sesvideoimporter_general', true); ?>" class="smoothbox">
                    <span class="sesimp_listing_item_thumb_img" style="background-image:url(<?php echo $imageurl; ?>);"></span>
                  </a>
                  <a href="<?php echo $this->url(array('action' => 'play', 'vid' => $videoID), 'sesvideoimporter_general', true); ?>" class="smoothbox sesimp_listing_item_play_btn sesbasic_animation">
                  	<i class="fa fa-play-circle"></i>
                  </a>
                  <a class="vedio_search_option sesimp_listing_item_add_btn sesbasic_animation" target="_blank" href="<?php echo $this->url(array('action' => 'create', 'vid' => $videoID), 'sesvideo_general', true); ?>" title="<?php echo $this->translate('Add Video'); ?>"><i class="fa fa-plus"></i></a>
                </div>
                <div class="sesimp_listing_item_info sesbasic_clearfix">
                	<p class="sesimp_listing_item_title">
                  	<a href="<?php echo $this->url(array('action' => 'play', 'vid' => $videoID), 'sesvideoimporter_general', true); ?>" class="smoothbox"><?php echo $this->string()->truncate($videoEntry['title'],$this->truncationLimit); ?></a>
                  </p>
                </div>
            	</div>
            </div>
        <?php endforeach; ?>
    </div>
    <ul class="paginationControl">
        <?php if('' != $this->searchResponse['prevPageToken']):?>
        <li>
            <a href="<?php echo $this->url(array('action' => 'search'), 'sesvideoimporter_import_youtube', true) ?>?text=<?php echo $this->query ?>&pageToken=<?php echo $this->searchResponse['prevPageToken'] ?>">&#171; Previous</a>
        </li>
        <?php endif;?>
        <?php if('' != $this->searchResponse['nextPageToken']):?>
        <li>
        <a href="<?php echo $this->url(array('action' => 'search'), 'sesvideoimporter_import_youtube', true) ?>?text=<?php echo $this->query ?>&pageToken=<?php echo $this->searchResponse['nextPageToken'] ?>">Next &#187;</a>
        </li>
        <?php endif;?>
    </ul> 
<?php }else{ ?>
    <div class="tip">
        <span>
            <?php echo $this->translate('No results found for ') . " '" . $this->query . "' -  "; ?>
            <?php echo $this->translate('Please try another one.'); ?>
        </span>
    </div>
<?php } ?>
</div>
<script>
function createVideo(url){
	window.location.href = url;	
}
</script>