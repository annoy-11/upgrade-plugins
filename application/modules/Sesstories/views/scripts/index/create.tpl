<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesstories
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: create.tpl 2018-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="sesstories_add_story_popup sesstories_bxs">
	<div class="sesstories_add_story_popup_header">
  	<?php echo $this->translate('Create New Story'); ?>
  </div>
  <form method="post" class="submit_stories">
    <div class="sesstories_add_story_popup_content">
      <div class="sesstories_add_story_field">
      	<div class="sesstories_story_uploader">
        	<article class="multi_upload_sesstories">
          	<i class="fas fa-plus"></i>
            <span><?php echo $this->translate("Upload Photo or Video"); ?></span>
          </article>
        </div>	
      </div>
      <div class="sesstories_story_uploaded_items" style="display: none">
        <div class="sesstories_story_uploaded_item">
          <article>
          	<img src="https://images.unsplash.com/photo-1583011538605-763f18554bdc?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60" alt="">
            <div class="_delete_btn"><a href="javascript:void(0);"></a></div>
          </article>
        </div>
      </div>
      <div class="sesstories_add_story_field">
      	<textarea placeholder="<?php echo $this->translate('Add description...'); ?>" id="sesstories_description"></textarea>
      </div>
    </div>
    <input type="file" id="file_multi_sesstories" style="display: none" onchange="readImageUrlsesstories(this)">
    <div class="sesstories_add_story_popup_footer">
    	<button type="submit" class="sesstories_btn_submit" disabled>Publish</button>
    </div>
  </form>
</div>




