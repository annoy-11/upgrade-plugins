<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<script>
  function shortcutButton(id, type) {
    
    if ($(type + '_shortcutunshortcuthidden_' + id))
    var contentId = $(type + '_shortcutunshortcuthidden_' + id).value
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesshortcut/index/shortcut',
      data: {
        format: 'json',
          'id': id,
          'type': type,
          'contentId': contentId
      },
      onSuccess: function(responseJSON) {
        if (responseJSON.shortcut_id) {
          if ($(type + '_shortcutunshortcuthidden_' + id))
            $(type + '_shortcutunshortcuthidden_' + id).value = responseJSON.shortcut_id;
          if ($(type + '_shortcut_' + id))
            $(type + '_shortcut_' + id).style.display = 'none';
          if ($(type + '_unshortcut_' + id))
            $(type + '_unshortcut_' + id).style.display = 'block';
          
        } else {
          if ($(type + '_shortcutunshortcuthidden_' + id))
            $(type + '_shortcutunshortcuthidden_' + id).value = 0;
          if ($(type + '_shortcut_' + id))
            $(type + '_shortcut_' + id).style.display = 'block';
          if ($(type + '_unshortcut_' + id))
            $(type + '_unshortcut_' + id).style.display = 'none';
        }
      }
    }));
  }
</script>
<?php if (!empty($this->viewer_id)): ?>
	<div class="sesbasic_clearfix sesbasic_bxs sesshortcut_button">
    <div class="" id="<?php echo $this->type ?>_shortcut_<?php echo $this->id; ?>" style ='display:<?php echo $this->isShortcut ? "none" : "block" ?>' >
      <a class="sesbasic_animation" href = "javascript:void(0);" onclick="shortcutButton('<?php echo $this->id; ?>', '<?php echo $this->type ?>');">
				<i class="fa fa-bookmark-o"></i><span><?php echo $this->translate("Add To Shortcuts") ?></span>
      </a>
    </div>
    <div id="<?php echo $this->type ?>_unshortcut_<?php echo $this->id; ?>" style='display:<?php echo $this->isShortcut ? "block" : "none" ?>' >
      <a class="sesbasic_animation" href="javascript:void(0);" onclick="shortcutButton('<?php echo $this->id; ?>', '<?php echo $this->type ?>');">
      	<i class="fa fa-bookmark"></i><span><?php echo $this->translate("Remove From Shortcuts") ?></span>
      </a>
    </div>
    <input type ="hidden" id = "<?php echo $this->type ?>_shortcutunshortcuthidden_<?php echo $this->id; ?>" value = '<?php echo $this->isShortcut ? $this->isShortcut : 0; ?>' />
  </div>
<?php endif; ?>