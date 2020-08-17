<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $item = $this->item;
  $allParams = $this->allParams;
?>
<?php if(isset($this->my_blogs) && $this->my_blogs) { ?> 
  <div class="eblog_options_buttons eblog_list_options sesbasic_clearfix">
    <?php if($this->can_edit) { ?>
      <a href="<?php echo $this->url(array('action' => 'edit', 'blog_id' => $item->blog_id), 'eblog_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Edit Blog'); ?>"><i class="fa fa-pencil"></i></a>
    <?php } ?>
    <?php if ($this->can_delete){ ?>
      <a href="<?php echo $this->url(array('action' => 'delete', 'blog_id' => $item->blog_id), 'eblog_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Delete Blog'); ?>" onclick='opensmoothboxurl(this.href);return false;'><i class="fa fa-trash"></i></a>
    <?php } ?>
  </div>
<?php } ?>
