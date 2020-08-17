<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-tables.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<div>
  <?php echo $this->htmlLink(array('module' => 'sespagebuilder','controller' => 'pricingtable'), $this->translate("Back to Manage Pricing Tables"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />
<div class='clear'>
  <div class='settings'>
    <form class="global_form">
      <div>
        <h3><?php echo $this->translate("Manage Pricing Table Columns") ?></h3>
        <p class="description">
          <?php echo $this->translate("This page lists all the columns of the associated pricing table. To create new column, use “Create New Column” link below.") ?>
        </p>        
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'add-column', 'content_id' => $this->content_id), $this->translate('Create New Column'), array('class' => 'buttonlink', 'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Core/externals/images/admin/new_category.png);')) ?><br /><br />        
        <?php if(count($this->columns)>0):?>
	  <div class="sespagebuilder_manage_columns">
	    <div class="sespagebuilder_manage_columns_head">
	      <div style="width:25%">
		<?php echo "Column Name";?>
	      </div>
	      <div style="width:25%">
		<?php echo "Footer URL";?>
	      </div>
	      <div style="width:50%" class="">
		<?php echo "Options";?>
	      </div>   
	    </div>
	    <ul class="sespagebuilder_manage_columns_list" id='menu_list'>
	      <?php foreach ($this->columns as $column):?>
		<li class="item_label" id="columns_<?php echo $column->pricingtable_id ?>">
		  <input type='hidden'  name='order[]' value='<?php echo $column->pricingtable_id; ?>'>
		  <div style="width:25%;">
		    <?php echo $column->column_title ?>
		  </div>
		  <div style="width:25%;" title="<?php echo $column->text_url;?>">
		    <a href="<?php echo $column->text_url;?>" target="_blank"><?php echo $this->string()->truncate($column->text_url, 20); ?></a>
		  </div>
		  <div style="width:50%;">
		    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'edit-column', 'id' => $column->pricingtable_id,'content_id' => $this->content_id), $this->translate('Edit'), array()) ?>
		    |
		    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'delete-column', 'id' => $column->pricingtable_id,'content_id' => $this->content_id), $this->translate('Delete'), array('class' => 'smoothbox')); ?>   
		    |
		    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'duplicate-column', 'id' => $column->pricingtable_id,'content_id' => $this->content_id), $this->translate('Duplicate Column'), array('class' => 'smoothbox')); ?>   
		  </div>
		</li>
	      <?php endforeach; ?>
	    </ul>
	  </div>
        <?php else:?>
	  <br/>
	  <div class="tip">
	    <span><?php echo $this->translate("There are currently no table columns.") ?></span>
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