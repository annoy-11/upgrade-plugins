<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_cloud_widget sesbasic_clearfix">
  <?php if($this->type == 'cloud'):?>
<?php
  $baseUrl = $this->layout()->staticBaseUrl;
  $randonNumber = $this->identity;
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.tagcanvas.min.js');
?>
    <div id="myCanvasContainer_<?php echo $randonNumber ?>" style="height:<?php echo $this->height;  ?>px;">
      <canvas style="width:100%;height:100%;" id="myCanvas_<?php echo $randonNumber ?>">
        <p><?php echo $this->translate("Anything in here will be replaced on browsers that support the canvas element"); ?></p>
        <ul>
          <?php foreach($this->paginator as $valueTags):?>
            <?php if($valueTags['text'] == '' || empty($valueTags['text'] )):?>
              <?php continue; ?>
            <?php endif;?>
            <li><a href="<?php echo $this->url(array('module' =>'sescrowdfunding','controller' => 'index', 'action' => 'browse'),'sescrowdfunding_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><?php echo $valueTags['text'] ?></a></li>
          <?php endforeach;?>
        </ul>
      </canvas>
    </div>
<script type="text/javascript">
  window.addEvent('domready', function() {
    if(!sesJqueryObject('#myCanvas_<?php echo $randonNumber ?>').tagcanvas({
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
  <?php else:?>
  	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
    <ul class="sesbasic_tags_list">
      <?php foreach($this->paginator as $valueTags):?>
        <?php if($valueTags['text'] == '' || empty($valueTags['text'] )):?>
          <?php continue; ?>
        <?php endif;?>
        <li><a href="<?php echo $this->url(array('module' =>'sescrowdfunding','controller' => 'index', 'action' => 'browse'),'sescrowdfunding_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><?php echo $valueTags['text'] ?></a></li>
      <?php endforeach;?>
    </ul>
  <?php endif;?>
  <a href="<?php echo $this->url(array('action' => 'tags'),'sescrowdfunding_general',true);?>" class="sesbasic_more_link clear"><?php echo $this->translate("See All Tags");?> &raquo;</a>
</div>
