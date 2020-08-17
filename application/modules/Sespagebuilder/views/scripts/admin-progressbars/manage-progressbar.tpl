<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-progressbar.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<div>
  <?php echo $this->htmlLink(array('module' => 'sespagebuilder','controller' => 'progressbars'), $this->translate("Back to Manage Progress Bars"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />
<div class='clear'>
  <div class='settings'>
    <form class="global_form">
      <div>
        <h3><?php echo $this->translate("Manage Progress Bars Values") ?></h3>
        <p class="description">
          <?php echo $this->translate("Here, create a new progress bar value by using “Create New Progress Bar Value” link below.") ?>
        </p>        
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'add-column', 'content_id' => $this->content_id), $this->translate('Create New Progress Bar Value'), array('class' => 'buttonlink sesbasic_icon_add')) ?><br /><br />        
        <?php if(count($this->columns)>0):?>
	  <div class="sespagebuilder_manage_columns">
	    <div class="sespagebuilder_manage_columns_head">
	      <div style="width:30%">
		<?php echo "Name";?>
	      </div>
	      <div style="width:20%">
		<?php echo "Enable";?>
	      </div>
	      <div style="width:20%">
		<?php echo "Percentage";?>
	      </div>
	      <div style="width:30%" class="">
		<?php echo "Options";?>
	      </div>   
	    </div>
	    <ul class="sespagebuilder_manage_columns_list" id='menu_list'>
	      <?php foreach ($this->columns as $column):?>
        <?php $serialize = unserialize($column->settings); ?>
		<li class="item_label" id="columns_<?php echo $column->progressbarcontent_id ?>">
		  <div style="width:30%;">
		    <?php echo $column->title ?>
		  </div>
		  <div style="width:20%;">
		    <?php echo $column->enable ? 'Yes' : 'No' ; ?>
		  </div>
		  <div style="width:20%;">
		    <?php echo $serialize['value']; ?>
		  </div>
		  <div style="width:30%;">
		    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'edit-column', 'id' => $column->progressbarcontent_id,'content_id' => $this->content_id), $this->translate('Edit'), array()) ?>
		    |
		    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'delete-column', 'id' => $column->progressbarcontent_id,'content_id' => $this->content_id), $this->translate('Delete'), array('class' => 'smoothbox')); ?>   
		   	|
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'duplicate-progressbar', 'id' => $column->progressbarcontent_id,'content_id' => $this->content_id), $this->translate("Duplicate Table"),array('class' => 'smoothbox')) ?>
		  </div>
		</li>
	      <?php endforeach; ?>
	    </ul>
	  </div>
        <?php else:?>
	  <br/>
	  <div class="tip">
	    <span><?php echo $this->translate("You have not created any progress values yet.") ?></span>
	  </div>
        <?php endif;?>
        <br/>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript"> 
  
  var SortablesInstance;

  window.addEvent('load', function() {
    SortablesInstance = new Sortables('menu_list', {
      clone: true,
      constrain: false,
      handle: '.item_label',
      onComplete: function(e) {
        reorder(e);
      }
    });
  });

 var reorder = function(e) {
     var menuitems = e.parentNode.childNodes;
     var ordering = {};
     var i = 1;
     for (var menuitem in menuitems)
     {
       var child_id = menuitems[menuitem].id;

       if ((child_id != undefined))
       {
         ordering[child_id] = i;
         i++;
       }
     }
 
    ordering['format'] = 'json';

    //Send request
    var url = '<?php echo $this->url(array("action" => "order")) ?>';
    var request = new Request.JSON({
      'url' : url,
      'method' : 'POST',
      'data' : ordering,
      onSuccess : function(responseJSON) {
      }
    });
    request.send();
  }
</script>
