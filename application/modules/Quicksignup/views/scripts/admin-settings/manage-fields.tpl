<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-fields.tpl  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Quicksignup/views/scripts/dismiss_message.tpl';?>
<h2>Signup Fields Settings</h2>
<p>Here, enable / disable the visibility of fields in the signup form. The Email, Password and Profile Type fields are mandatory fields and thus can not be disabled.</p>
<br>
<form method="post">
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
  <div class='sesbasic_admin_form'>
    <div class='clear'>
      <div class="sesbasic_manage_table">
        <div class="sesbasic_manage_table_head" style="width:100%;">
          <div style="width:45%">
            Labels
          </div>
          <div style="width:45%">
            Status
          </div>
        </div>
        <ul class="sesbasic_manage_table_list" id='menu_list' style="width:100%;">
          <?php foreach($this->paginator as $item){ ?>
          <li class="item_label" id="order_<?php echo $item->enablefield_id; ?>">
            <input type="hidden" name="order[]" value="<?php echo $item->enablefield_id; ?>">
            <div style="width: 45%"><?php echo $item->title; ?></div>

            <div style="width: 45%">
              <?php if($item->type != 'email' && $item->type != "profile_types" && $item->type != "password"){ ?>
                <a href="<?php echo $this->url(array('module'=>'quicksignup','controller'=>'settings','action'=>'enable','id'=>$item->enablefield_id),'admin_default',true); ?>">
              <?php } ?>
                <?php if($item->display == 1){ ?>
              <img src="application/modules/Sesbasic/externals/images/icons/check.png" alt="">
              <?php }else{ ?>
              <img src="application/modules/Sesbasic/externals/images/icons/error.png" alt="">
              <?php  } ?>
              <?php if($item->type != 'email' && $item->type != "profile_types" && $item->type != "password"){ ?>
                </a>
              <?php  } ?>
            </div>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
<div class='buttons'>
  <button type='submit'><?php echo $this->translate('Save Order'); ?></button>
</div>
</form>
<script type="text/javascript">
    var SortablesInstance;
    window.addEvent('load', function() {
        SortablesInstance = new Sortables('menu_list', {
            clone: true,
            constrain: false,
            handle: '.item_label',
            onComplete: function(e) {
                //reorder(e);
            }
        });
    });


</script>