<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _feelingemojicomment.tpl  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="feeling_emoji_content">
  <?php 
    if($this->edit)
      $class="edit";
    else
      $class = '';
    $getEmojis = Engine_Api::_()->getDbTable('emojis', 'sesemoji')->getEmojis(array('fetchAll' => 1)); ?>
    <div class="sesbasic_custom_scroll">
      <ul  id="sesbasic_custom_scrollul" class="sesfeelact_simemoji">
        <?php foreach($getEmojis as $key => $getEmoji) {
          
          $getEmojiicons = Engine_Api::_()->getDbTable('emojiicons', 'sesemoji')->getEmojiicons(array('emoji_id' => $getEmoji->emoji_id, 'fetchAll' => 1));
          if(count($getEmojiicons) > 0) { ?>
          
          <li id="main_emiji_<?php echo $getEmoji->getIdentity(); ?>">
            <span class="sesbasic_text_light"><?php echo $this->translate($getEmoji->title); ?></span>
            <ul>
              <?php foreach($getEmojiicons as $key => $getEmojiicon) {
                $emoIcon = "\u{$getEmojiicon->emoji_icon}";
                $emoIcon = preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;", $emoIcon);
              ?>
              <li title="<?php echo $getEmojiicon->title; ?>" rel="<?php echo $getEmojiicon->emoji_icon; ?>" data-icon="<?php echo $emoIcon ?>">
                <a href="javascript:;" class="select_feeling_emoji_adv<?php echo $class; ?>"><img src="<?php echo Engine_Api::_()->storage()->get($getEmojiicon->file_id, '')->getPhotoUrl(); ?>"></a>
              </li>
              <?php } ?>
            </ul>
        </li>
        <?php }
        } ?>
      </ul>
    </div>
    <?php if(count($getEmojis) > 0): ?>
      <div class="feeling_emoji_content_footer">
        <?php foreach($getEmojis as $key => $getEmoji): ?>
          <?php $getEmojiicons = Engine_Api::_()->getDbTable('emojiicons', 'sesemoji')->getEmojiicons(array('emoji_id' => $getEmoji->emoji_id, 'fetchAll' => 1)); ?>
          <?php $photo = Engine_Api::_()->storage()->get($getEmoji->file_id, '');
          if($photo) {
          $photo = $photo->getPhotoUrl(); ?>
          <?php if(count($getEmojiicons) > 0) { ?>
            <a rel="<?php echo $getEmoji->getIdentity(); ?>" class="emojis_clicka" href="javascript:void(0);" title="<?php echo $getEmoji->title; ?>"><img src="<?php echo $photo; ?>"></a>
          <?php } } ?>
          
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    
    <?php if(!$this->edit) { ?>
    
    <script type="application/javascript">
    
      function activityFeedAttachmentFeelingEmoji(that) {

        var feeling_emoji_icon = sesJqueryObject(that).parent().parent().attr('data-icon');
        var html = sesJqueryObject('.compose-content').html();
        if(html == '<br>')
          sesJqueryObject('.compose-content').html('');

        //composeInstance.setContent(composeInstance.getContent()+' '+feeling_emoji_icon);
        composeInstance.setContent(composeInstance.getContent()+feeling_emoji_icon);

        var data = composeInstance.getContent();
        EditFieldValue = data;

        sesJqueryObject('#activity_body').trigger('focus');
        autosize($(that));
        
      }
      
      function commentContainerSelectFeelingEmoji(that) {

        var feeling_emoji_icon = sesJqueryObject(that).parent().parent().attr('data-icon');
        
        var elem = sesJqueryObject(clickFeelingEmojiContentContainer).parent().parent().parent().find('.body');
        if(elem.html() == '<br>')
         elem.html('');
        elem.val(elem.val()+' '+feeling_emoji_icon);

        EditFieldValue = elem.val()
        sesJqueryObject(elem).trigger('focus');
      }
      
      sesJqueryObject(document).on('click','.select_feeling_emoji_adv > img',function(e) {
      
        if(sesJqueryObject(clickFeelingEmojiContentContainer).attr('id') == 'sesadvancedactivity_feeling_emojis') {
          activityFeedAttachmentFeelingEmoji(this);  
        } else
          commentContainerSelectFeelingEmoji(this);
          
        //sesJqueryObject('.exit_emoji_btn').trigger('click');
      });
      
      sesJqueryObject(document).on('click','.emojis_clicka',function(e) {
        var emojiId = sesJqueryObject(this).attr('rel');
        jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar("scrollTo",jqueryObjectOfSes('.sesbasic_custom_scroll').find('.mCSB_container').find('#sesbasic_custom_scrollul').find('#main_emiji_'+emojiId));          
      });
    </script>
    <?php } ?>
</div>