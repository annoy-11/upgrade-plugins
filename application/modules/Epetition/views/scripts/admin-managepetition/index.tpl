<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected petition entries?');?>");
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

<?php include APPLICATION_PATH .  '/application/modules/Epetition/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate('Manage Petitions'); ?></h3>
<p>
  <?php echo $this->translate("This page lists all of the petition your users have posted. You can use this page to monitor these petitions and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific petition entries. Leaving the filter fields blank will show all the petition entries on your social network.<br />Below, you can also choose any number of petitions as Petition of the Day, Featured, Sponsored, Verified. You can also Approve and Disapprove petitions.") ?>
</p>

<br />

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>	
<br />	
<br />
<?php $isEnablePackage = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epetitionpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetitionpackage.enable.package', 1); ?>
<?php $counter = $this->paginator->getTotalItemCount(); ?>
<?php if( count($this->paginator) ): ?>
	<div class="sesbasic_search_reasult">
		<?php echo $this->translate(array('%s petition found.', '%s petitions found.', $counter), $this->locale()->toNumber($counter)) ?>
	</div>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
      <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('epetition_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('owner_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Approved") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('is_approved', 'ASC');"><?php echo $this->translate("A") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Featured") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('featured', 'ASC');"><?php echo $this->translate("F") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Sponsored") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('sponsored', 'ASC');"><?php echo $this->translate("S") ?></a></th>
      <th align="center" title="<?php echo $this->translate("Verified") ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('verified', 'ASC');"><?php echo $this->translate("V") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Of the Day") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('offtheday', 'ASC');"><?php echo $this->translate("OTD") ?></a></th>
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
	  <?php if($item->is_approved == 1):?>
	    <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'approved', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Approved')))) ?>
	  <?php else: ?>
	    <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'approved', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Approved')))) ?>
	  <?php endif; ?>
        </td> 
	<td class="admin_table_centered">
	  <?php if($item->is_approved == 1){?>
	    <?php if($item->featured == 1):?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'featured', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
	    <?php else: ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'featured', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
	    <?php endif; ?>
	  <?php }else{ ?>      -
	  <?php } ?>
	</td>
	<td class="admin_table_centered">
	  <?php if($item->is_approved == 1){?>
	    <?php if($item->sponsored == 1):?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'sponsored', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
	    <?php else: ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'sponsored', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
	    <?php endif; ?>
	  <?php }else{ ?>
	  -
	  <?php } ?>          
        </td>
	<td class="admin_table_centered">
	  <?php if($item->is_approved == 1){?>
	    <?php if($item->verified == 1): ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'verify', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Verify')))) ?>
	    <?php else: ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'verify', 'id' => $item->epetition_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Verify')))) ?>
	    <?php endif; ?>
	  <?php }else{ ?>
	  -
	  <?php } ?> 
	</td>
        <td class="admin_table_centered">
	  <?php if(strtotime($item->endtime) < strtotime(date('Y-m-d')) && $item->offtheday == 1){ 
	    Engine_Api::_()->getDbtable('epetitions', 'epetition')->update(array(
	      'offtheday' => 0,
	      'starttime' =>'',
	      'endtime' =>'',
	    ), array(
	      "epetition_id = ?" => $item->epetition_id,
	    ));
	    $itemofftheday = 0;
	  }else
	  $itemofftheday = $item->offtheday; ?>
	  <?php if($item->is_approved == 1):?>
	    <?php if($itemofftheday == 1):?>  
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'oftheday', 'id' => $item->epetition_id, 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Petition of the Day'))), array('class' => 'smoothbox')); ?>
	    <?php else: ?>
	      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'oftheday', 'id' => $item->epetition_id, 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Petition of the Day'))), array('class' => 'smoothbox')) ?>
	    <?php endif; ?>
	  <?php else:?>
	  -
	  <?php endif;?>
        </td>
       <?php if($isEnablePackage){ 
       		$package = $item->getPackage();
       ?>
        <td><a href="javascript:;"><?php echo $package->getTitle(); ?></a></td>
        <td>
        	<?php if($package->price < 1){
          	echo "FREE";
          }else{ 
          	$currentCurrency = Engine_Api::_()->epetition()->getCurrentCurrency();
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
              	$table = Engine_Api::_()->getDbTable('transactions','epetitionpackage');
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
					<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'view','id' => $item->epetition_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
          |
          <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'epetition_dashboard', 'epetition_id' => $item->custom_url), $this->translate('edit'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(
	  array('route' => 'default', 'module' => 'epetition', 'controller' => 'admin-managepetition', 'action' => 'delete', 'id' => $item->epetition_id),
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
      <?php echo $this->translate("There are no petition entries by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>

<script>
 function showSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'epetition/index/subcategory/category_id/' + cat_id;
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
    var url = en4.core.baseUrl + 'epetition/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "inline-block";
          }
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
