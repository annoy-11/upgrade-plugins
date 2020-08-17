<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _designations.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(count($this->designations) > 0) { ?>
  <?php foreach($this->designations as $key => $item) { ?>
    <ul>
      <li class="sesbasic_clearfix" id="sespageteam_designation_<?php echo $item->designation_id; ?>">
        <div class="_title"><?php echo $this->translate($item->designation); ?></div>
        <?php if($item->page_id && empty($item->is_admincreated)) { ?>
          <div class="_btns">
            <a href="<?php echo $this->url(array('page_id' => $item->page_id,'designation_id' => $item->designation_id, 'action'=>'edit-designation'),'sespageteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-pencil"></i></a>
            <a href="<?php echo $this->url(array('page_id' => $item->page_id,'designation_id' => $item->designation_id,'action'=>'delete-designation'),'sespageteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-trash"></i></a>
          </div>
        <?php } ?>
      </li>
    </ul>
  <?php } ?>
<?php } else { ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no designations yet.");?>
    </span>
  </div>
<?php } ?>