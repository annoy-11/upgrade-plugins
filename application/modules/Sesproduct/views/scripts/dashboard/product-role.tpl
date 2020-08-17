<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: product-role.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?> 
<?php if(!$this->is_ajax):?> 
	<?php $base_url = $this->layout()->staticBaseUrl;?>
	<?php $this->headScript()
	->appendFile($base_url . 'externals/autocompleter/Observer.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
	?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array('product' => $this->product));	?>
<div class="estore_dashboard_content sesproduct_manage_role_form sesbm sesbasic_clearfix">
	<div class="sesproduct_manage_role_form_top sesbasic_clearfix">
		<p class="heading_desc"><?php echo $this->translate('Below, you can add admins to your product who all will be able to do anything on your product as you do including editing, creating sub product, etc.');?></p>
		<?php endif; ?>
		<form id="product_admin_form" action="<?php echo $this->url(array('action' => 'save-product-admin', 'product_id' => $this->product->product_id), 'sesproduct_dashboard', true) ?>" method="post">
			<div id="manage_admin_input">
				<div class="sesproduct_manage_roles_item">
					<span class="show_img" id="show_default_img"></span>
					<input type='text' id="product_admin" name='product_admin' size='20' placeholder='<?php echo $this->translate('Type Member Name') ?>' />
					<input type="hidden" id="user_id" name="product_admins[]" value=""/>
				</div>
			</div>
			<a href="javascript:void(0);" onclick="addMore();"><i class="fa fa-plus"></i>&nbsp;<?php echo $this->translate('Add Another Member');?></a>
			<button onclick="saveForm();return false;" id="save_button_admin" disabled><?php echo $this->translate("Save Admin"); ?></button>
	  </form>
<?php if(!$this->is_ajax){ ?>
  </div>
	<div class="sesproduct_footer_contant">
		<b><?php echo $this->translate('Admins');?></b>
		<p><?php echo $this->translate('And so when Rihanna, in the middle of soaking up the sun on her swan float — a required activity for all celebrities — realized that she was losing her balance, her priorities were clear. RiRi gloriously emerged like Aphrodite from the water, wine glass in hand.');?></p>
		<div id="manage_admin">
			<?php foreach($this->paginator as $productAdmin):?>
				<div class="admin_manage" id="admin_manage_<?php echo $productAdmin->role_id;?>">
					<?php $user = Engine_Api::_()->getItem('user', $productAdmin->user_id);?>
					<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
          <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
          <?php if($productAdmin->user_id != $this->product->owner_id):?>
						<a class="remove_product" href="javascript:void(0);" onclick="removeUser('<?php echo $productAdmin->product_id;?>','<?php echo $productAdmin->role_id;?>');"><i class="fa fa-times"></i></a>
          <?php endif;?>
					
          <br />
				</div>
			<?php endforeach;?>
		</div>
	</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
<script type="text/javascript">
	function showAutosuggest(productAdmin, imageId) {
	  var contentAutocomplete1 =  'contentAutocomplete-'+productAdmin
		contentAutocomplete1 = new Autocompleter.Request.JSON(productAdmin, "<?php echo $this->url(array('module' => 'sesproduct', 'controller' => 'dashboard', 'action' => 'get-members', 'product_id' => $this->product->product_id), 'default', true) ?>", {
			'postVar': 'text',
			'minLength': 1,
			'selectMode': '',
			'autocompleteType': 'tag',
			'customChoices': true,
			'filterSubset': true,
			'maxChoices': 20,
			'cache': false,
			'multiple': false,
			'className': 'sesbasic-autosuggest',
			'indicatorClass':'input_loading',
			'injectChoice': function(token) {
				var choice = new Element('li', {
					'class': 'autocompleter-choices', 
					'html': token.photo, 
					'id':token.label
				});
				new Element('div', {
					'html': this.markQueryValue(token.label),
					'class': 'autocompleter-choice'
				}).inject(choice);
				this.addChoiceEvents(choice).inject(this.choices);
				choice.store('autocompleteChoice', token);
			}
		});
		contentAutocomplete1.addEvent('onSelection', function(element, selected, value, input) {
			if($('user_id').value != '')
			 $('user_id').value = $('user_id').value+','+selected.retrieve('autocompleteChoice').id;
			else
			 $('user_id').value = selected.retrieve('autocompleteChoice').id;
      $(imageId).innerHTML = selected.retrieve('autocompleteChoice').photo;
			sesJqueryObject('#'+productAdmin).attr('rel', selected.retrieve('autocompleteChoice').id);
			sesJqueryObject('#save_button_admin').removeAttr('disabled');
		});
	}
	en4.core.runonce.add(function() {
	  showAutosuggest('product_admin','show_default_img');
	});
	
	function saveForm() {
	  var UserIds = $('user_id').value;
		new Request.HTML({
			url : en4.core.baseUrl + 'sesproduct/dashboard/save-product-admin/product_id/' + <?php echo $this->product->product_id ?>,
			method: 'post',
			data : {
				format : 'html',
				data: UserIds,
				is_ajax: 1,
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				$('manage_admin').innerHTML = responseHTML;
			}
		}).send()
	}
	
	sesJqueryObject(document).on('keyup', 'input[id^="product_admin"]', function(event) {
    var value = sesJqueryObject(this);
		if(!value.val()){
			var id = value.attr('rel');
			if(typeof id == 'undefined')
				return false;
			var str = $('user_id').value;
			var res = str.replace(id, "");
			sesJqueryObject('#user_id').val(res);
			if(res == '' || res == ',')
				sesJqueryObject('#save_button_admin').attr('disabled', true);
			value.parent().find('.show_img').html('');				
		}
	});
	
	var count = 1;
	function addMore() {
		var itemCount = sesJqueryObject('#manage_admin_input').children().length - 1;
		var currentElem = sesJqueryObject('#manage_admin_input').children().eq(itemCount).find('input').first().val();
		if(!currentElem || !sesJqueryObject('#manage_admin_input').children().eq(itemCount).find('input').first().attr('rel'))
			return false;
	  var ColumnId = 'product_admin_'+count;
	  sesJqueryObject('#manage_admin_input').append('<div class="sesproduct_manage_roles_item"><span class="show_img" id="show_default_img_'+count+'"'+'></span> <input type="text" placeholder="Type Member Name" size="20" name="'+ColumnId+'"' +'id="'+ColumnId+'"'+'autocomplete="off" rel="'+count+'"><a class="remove_icon" href="javascript:void(0);" onclick="removeInputForm('+"'"+ColumnId+"'"+');"><i class="fa fa-times" id="close_option_'+count+'"'+'></i></a></div>');
	  showAutosuggest('product_admin_'+count, 'show_default_img_'+count);
	  count = count+1;
	}
	
  function removeInputForm(id) {
    var explodedstr = id.split("_"); 
    var countNumber = explodedstr['2'];
    var str = $('user_id').value;
    var res = str.replace(sesJqueryObject('#'+id).attr('rel'), "");
		var itemS = sesJqueryObject('#show_default_img_'+countNumber);
		itemS.parent().remove();
    sesJqueryObject('#user_id').val(res);
    if(res == '' || res == ',') {
			sesJqueryObject('#save_button_admin').attr('disabled', true)
    }
  }
  
  function removeUser(productId, roleId) {
		new Request.JSON({
			url : en4.core.baseUrl + 'sesproduct/dashboard/delete-product-admin',
			method: 'post',
			data : {
				format : 'json',
				role_id: roleId,
				product_id: productId,
				is_ajax: 1,
			},
			onSuccess: function(responseJSON) {
				sesJqueryObject('#admin_manage_'+roleId).remove();
			}
		}).send()
  }
</script>
