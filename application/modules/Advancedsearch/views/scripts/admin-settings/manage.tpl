<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?><?php include APPLICATION_PATH .  '/application/modules/Advancedsearch/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_advancedsearch_result">
  <a href="<?php echo $this->url(array('module'=>'advancedsearch','controller'=>'settings','action'=>'add'),'admin_default',true); ?>" class="buttonlink sesbasic_icon_add otpsms_icon_create">Add new Content Type</a>
  <br /><br />
</div>
<form method="post">
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
  <div class='sesbasic_admin_form'>
    <div class='clear'>
      <div class="sesbasic_manage_table">
        <div class="sesbasic_manage_table_head" style="width:100%;">
          <div style="width:20%">
            Content Module
          </div>
          <div style="width:20%">
            Title
          </div>
          <div style="width:15%">
            Show in Search Box
          </div>
          <div style="width:20%">
            Show Tab on Search Page
          </div>
          <div style="width:15%">
            Icon
          </div>
          <div style="width:5%">
            Options
          </div>
        </div>
        <ul class="sesbasic_manage_table_list" id='menu_list' style="width:100%;">
          <?php foreach($this->paginator as $item){ ?>
          <li class="item_label" id="order_<?php echo $item->module_id; ?>">
            <input type="hidden" name="order[]" value="<?php echo $item->module_id; ?>">
            <div style="width:20%"><?php echo $item->resource_title; ?></div>
            <div style="width:20%"><?php echo $item->title; ?></div>
            <div style="width:15%">
              <a href="<?php echo $this->url(array('module'=>'advancedsearch','controller'=>'settings','action'=>'show-on-search','id'=>$item->module_id),'admin_default',true); ?>">
                <?php if($item->show_on_search){ ?>
                <img src="application/modules/Sesbasic/externals/images/icons/check.png" alt="">
                <?php }else{ ?>
                <img src="application/modules/Sesbasic/externals/images/icons/error.png" alt="">
                <?php  } ?>
              </a>
            </div>
            <div style="width:20%">
              <a href="<?php echo $this->url(array('module'=>'advancedsearch','controller'=>'settings','action'=>'create-tab','id'=>$item->module_id),'admin_default',true); ?>">
                <?php if($item->create_tab){ ?>
                <img src="application/modules/Sesbasic/externals/images/icons/check.png" alt="">
                <?php }else{ ?>
                <img src="application/modules/Sesbasic/externals/images/icons/error.png" alt="">
                <?php  } ?>
              </a>
            </div>
            <div style="width:15%">
              <img src="<?php echo $item->getPhotoUrl(); ?>">
            </div>
            <div>
              <a class="smoothbox" href="<?php echo $this->url(array('module'=>'advancedsearch','controller'=>'settings','action'=>'edit','id'=>$item->module_id),'admin_default',true); ?>">Edit</a>
              <?php if($item->is_deleted){ ?>
                <a href="<?php echo $this->url(array('module'=>'advancedsearch','controller'=>'settings','action'=>'delete','id'=>$item->module_id),'admin_default',true); ?>">Delete</a>
              <?php } ?>
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
            clone:true,
            constrain:false,
            handle:'.item_label',
            onComplete:function(e) {
                //reorder(e);
            }
        });
    });
</script>

