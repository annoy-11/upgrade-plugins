<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: wishlist.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/style_dashboard.css'); ?>
<script type="text/javascript">
  var currentOrder = '<?php echo $this->order ?>';
  var currentOrderDirection = '<?php echo $this->order_direction ?>';
  var changeOrder = function(order, default_direction){
    // Just change direction
    if( order == currentOrder ) {
      $('order_direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
    } else {
      $('order').value = order;
      $('order_direction').value = default_direction;
    }
    $('filter_form').submit();
  }

  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected wishlists?');?>");
  }
  function selectAll() {
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length; i++) {
      if (!inputs[i].disabled) {
	inputs[i].checked = inputs[0].checked;
      }
    }
  }
</script>

<?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate('Manage Wishlists'); ?></h3>
<p>
  <?php echo $this->translate("This page lists all of the wishlists your users have created. You can use this page to monitor these wishlists and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific wishlists. Leaving the filter fields blank will show all the wishlists on your social network.") ?>
</p>

<br />

<div class='estore_search_form estore_browse_search_horizontal estore_admin_search_form sesbasic_bxs'>
  <?php echo $this->formFilter->render($this); ?>
</div>	
<br />	
<br />
<?php $isEnablePackage = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1); ?>
<?php $counter = $this->paginator->getTotalItemCount(); ?>
<?php if( count($this->paginator) ): ?>
	<div class="sesbasic_search_reasult">
		<?php echo $this->translate(array('%s Wishlist found.', '%s Wishlists found.', $counter), $this->locale()->toNumber($counter)) ?>
	</div>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
      <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('wishlist_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('owner_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Featured") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('is_featured', 'ASC');"><?php echo $this->translate("F") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Sponsored") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('is_sponsored', 'ASC');"><?php echo $this->translate("S") ?></a></th>
      <th align="center" title="<?php echo $this->translate("Private") ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('is_private', 'ASC');"><?php echo $this->translate("P") ?></a></th>
        <?php if($isEnablePackage){ ?>
     	<th><?php echo $this->translate("Package"); ?></th>
     	<th><?php echo $this->translate("Price"); ?></th>
      <th><?php echo $this->translate("Expiration Date"); ?></th>
     <?php } ?>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr>
        <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
        <td><?php echo $item->getIdentity() ?></td>
				<td>
					<?php if(strlen($item->getTitle()) > 7):?>
						<?php $title = mb_substr($item->getTitle(),0,7).'...';?>
						<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
					<?php else: ?>
						<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
					<?php endif;?>
				</td>
        <td><a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $item->getOwner()->getTitle() ?></a></td>
	<td class="admin_table_centered">
	  <?php if(1){?>
	    <?php if($item->is_featured == 1):?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'featured', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
	    <?php else: ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'featured', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
	    <?php endif; ?>
	  <?php }else{ ?>      -
	  <?php } ?>
	</td>
	<td class="admin_table_centered">
	    <?php if($item->is_sponsored == 1):?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'sponsored', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
	    <?php else: ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'sponsored', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
	    <?php endif; ?>
	         
        </td>
	<td class="admin_table_centered">

	    <?php if($item->is_private == 1): ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'verify', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Private')))) ?>
	    <?php else: ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'verify', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Private')))) ?>
	    <?php endif; ?>
	</td>

       <?php if($isEnablePackage){ 
       		$package = $item->getPackage();
       ?>
        <td><a href="javascript:;"><?php echo $package->getTitle(); ?></a></td>
        <td>
        	<?php if($package->price < 1){
          	echo "FREE";
          }else{ 
          	$currentCurrency = Engine_Api::_()->sesproduct()->getCurrentCurrency();
            echo $package->getPackageDescription();
          } ?>
        </td>
        <td>
        	<?php if($package->price < 1){
          	echo "Never Expires";
          }else{ 
          	$transaction = $item->getTransaction();
            if(!$transaction){
            	if($item->orderspackage_id){
              	$table = Engine_Api::_()->getDbTable('transactions','sesproductpackage');
                $tableName = $table->info('name');
								$select = $table->select()->from($tableName)->where('orderspackage_id =?',$item->orderspackage_id)->where('gateway_profile_id !=?','')->where('state = "pending" || state = "complete" || state = "okay" || state = "active"')->limit(1);
								$transaction =  $table->fetchRow($select);
                if($transaction){
                	echo date('Y-m-d H:i:s');
                }else{
                	echo "Unlimited";
                }
             	}else{
            		echo "Unlimited";	
              }
            }else{
            	echo date('Y-m-d H:i:s');
            }
          }
          ?>
        </td>
       <?php } ?>
        <td><?php echo $item->creation_date ?></td>
        <td>
					<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'view-wishlist','id' => $item->wishlist_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
          |
          <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'sesproduct_wishlist_view', 'wishlist_id' => $item->wishlist_id,'action'=>'edit','slug'=>''), $this->translate('edit'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'admin-manage', 'action' => 'delete-wishlist', 'wishlist_id' => $item->wishlist_id),
                $this->translate("delete"),
                array('class' => 'smoothbox')) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br />
<div class='buttons'>
  <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
</div>
</form>

<br/>
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>

<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no wishlists created by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>

<script>
 function showSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesproduct/index/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id')) {
            $('subcat_id-label').parentNode.style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id')) {
            $('subcat_id-label').parentNode.style.display = "none";
            $('subcat_id').innerHTML = '';
          }
					 if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }).send(); 
  }
	function showSubSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesproduct/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "inline-block";
          }wishlist
          $('subsubcat_id').innerHTML = responseHTML;
					// get category id value 
        } else {
          if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    })).send();  
 }
	var sesdevelopment = 1;
	<?php if(isset($this->category_id) && $this->category_id != 0){ ?>
			<?php if(isset($this->subcat_id) && $this->subcat_id != 0){$catId = $this->subcat_id;}else $catId = ''; ?>
      showSubCategory('<?php echo $this->category_id ?>','<?php echo $catId; ?>');
   <?php  }else{?>
	  $('subcat_id-label').parentNode.style.display = "none";
	 <?php } ?>
	 <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
      showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>');
	 <?php }else{?>
	 		 $('subsubcat_id-label').parentNode.style.display = "none";
	 <?php } ?>
</script>
