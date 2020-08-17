<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox	
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: loadmorecontents.tpl  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php ?>
<?php $shoutbox = $this->shoutbox; ?>
<?php if(count($this->results)) { ?>
  <?php for($i=count($this->results);$i>=1;$i--) {
      $content = $this->results[$i-1]; ?>
  <?php $poster = Engine_Api::_()->getItem('user', $content->poster_id); ?>
  <?php if($this->viewer_id != $content->poster_id) { ?>
  
    <div class="sessbx_msg_item sessbx_msg_item_receive" data-id="<?php echo $content->getIdentity(); ?>">
      <article class="sessbx_clearfix">
        <div class="sessbx_msg_item_photo">
          <?php echo $this->htmlLink($poster->getHref(), $this->itemPhoto($poster, 'thumb.icon', $poster->getTitle())) ?>
        </div>
        <div class="sessbx_msg_item_body sessbx_clearfix">
          <div class="sessbx_msg_item_body_inner">
            <div class="_cont" style="background-color:#<?php echo $shoutbox->other_background_color; ?>;">
              <div class="_name"><a href="<?php echo $poster->getHref(); ?>"><?php echo $poster->getTitle(); ?></a></div>
              <div class="_body" id="sesshoutbox_message_boy_<?php echo $content->getIdentity(); ?>" style="font-size:<?php echo $shoutbox->font_size; ?>px;font-color:#<?php echo $shoutbox->other_font_color; ?>;"> 
              <?php $contents = Engine_Api::_()->sesshoutbox()->smileyToEmoticons($content->body); ?>   
                      <?php echo $contents; ?>
              </div>
            </div>
            <div class="_time sessbx_text_light"><?php echo $this->timestamp($content->creation_date); ?></div>
          </div>
        </div>
        <?php if($this->viewer_id && $this->viewer_id != $content->poster_id) { ?>
          <div class="_option">
            <div class="_optioninner">
              <div class="_options_pulldown">
                <a class="smoothbox" href="<?php echo $this->url(array('module'=>'sesshoutbox','controller'=>'index','action'=>'report', 'resource_id' => $content->getIdentity(), 'resource_type' => 'sesshoutbox_content'), 'default' , true); ?>"><?php echo $this->translate("Report")?></a>
              </div>	
              <i class="fa fa-ellipsis-h"></i>
            </div>  
          </div>
        <?php } ?>
      </article>	
    </div>
  <?php } else if($this->viewer_id == $content->poster_id) { ?>
    <div class="sessbx_msg_item sessbx_msg_item_send" data-id="<?php echo $content->getIdentity(); ?>">
      <article class="sessbx_clearfix">
        <div class="_option">
          <div class="_optioninner">
            <div class="_options_pulldown">
              <a class="sessmoothbox" href="sesshoutbox/index/edit-message/content_id/<?php echo $content->getIdentity(); ?>"><?php echo $this->translate("Edit")?></a>
              <a href="javascript:void(0);" onclick="deleteMessage('<?php echo $content->getIdentity(); ?>', '<?php echo $content->shoutbox_id; ?>')"><?php echo $this->translate("Delete")?></a>
            </div>	
            <i class="fa fa-ellipsis-h"></i>
          </div>  
        </div>
        <div class="sessbx_msg_item_body sessbx_clearfix">
          <div class="sessbx_msg_item_body_inner">
            <div class="_cont" style="background-color:#<?php echo $shoutbox->my_background_color; ?>;">
              <div class="_body" id="sesshoutbox_message_boy_<?php echo $content->getIdentity(); ?>" style="font-size:<?php echo $shoutbox->font_size; ?>px;font-color:#<?php echo $shoutbox->my_font_color; ?>;">
              <?php $contents = Engine_Api::_()->sesshoutbox()->smileyToEmoticons($content->body); ?>    
              <?php echo $contents; ?>
              </div>
            </div>
            <div class="_time sessbx_text_light"><?php echo $this->timestamp($content->creation_date); ?></div>
          </div>
        </div>
      </article>	
    </div>
  <?php } ?>
  <?php } ?>
<?php } ?>
