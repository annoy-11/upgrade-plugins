<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl;
  $randonNumber = $this->identity;
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.tagcanvas.min.js'); 
?>

<div class="sesbasic_cloud_widget sesbasic_clearfix">
  <?php if($this->type == 'cloud'):?>
    <div id="myCanvasContainer_<?php echo $randonNumber ?>" style="height:<?php echo $this->height;  ?>px;">
      <canvas style="width:100%;height:100%;" id="myCanvas_<?php echo $randonNumber ?>">
        <p><?php echo $this->translate("Anything in here will be replaced on browsers that support the canvas element"); ?></p>
        <ul>
          <?php foreach($this->paginator as $valueTags):?>
            <?php if($valueTags['text'] == '' || empty($valueTags['text'])) continue; ?>
            <li><a href="<?php echo $this->url(array('module' =>'eblog','controller' => 'index', 'action' => 'browse'),'eblog_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><?php echo $valueTags['text'] ?></a></li>
          <?php endforeach;?>
        </ul>
      </canvas>
    </div>
  <?php else:?>
  <div class="eblog_tags_cloud_blog sesbasic_bxs ">
  	<ul class="eblog_tags_cloud_list">
      <?php foreach($this->paginator as $valueTags):?>
        <?php if($valueTags['text'] == '' || empty($valueTags['text'] )) continue; ?>
        <li><a href="<?php echo $this->url(array('module' =>'eblog','controller' => 'index', 'action' => 'browse'),'eblog_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><?php echo $valueTags['text'] ?></a></li>
      <?php endforeach;?>
    </ul>
  </div>
  <?php endif;?>
  <a href="<?php echo $this->url(array('action' => 'tags'),'eblog_general',true);?>" class="sesbasic_more_link clear"><?php echo $this->translate("See All Tags");?> &raquo;</a>
</div>
<script type="text/javascript">
  window.addEvent('domready', function() {
    if( ! sesJqueryObject ('#myCanvas_<?php echo $randonNumber ?>').tagcanvas({
      textFont: 'Impact,"Arial Black",sans-serif',
      textColour: "<?php echo $this->color; ?>",
      textHeight: "<?php echo $this->textHeight; ?>",
      maxSpeed : 0.03,
      depth : 0.75,
      shape : 'sphere',
      shuffleTags : true,
      reverse : false,
      initial :  [0.1,-0.0],
      minSpeed:.1
    })) {
      // TagCanvas failed to load
      sesJqueryObject ('#myCanvasContainer_<?php echo $randonNumber ?>').hide();
    }
  });
 </script>
