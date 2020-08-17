<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete selected Stores?');?>");
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
<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Stores") ?></h3>
<p><?php echo $this->translate('This page lists all of the Stores your users have created on your website. You can use this page to monitor these Stores and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific store. Leaving the filter fields blank will show all the stores on your social network. <br /> <br />Below, you can also choose any number of Stores as Stores of the Day, Featured, Sponsored, Verified and Hot. You can also Approve and Disapprove stores.<br /> If you want to change the owner of a Store, then you can do so by using the "Transfer Ownership" option.'); ?></p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s store found.', '%s stores found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="admin_table_form">
      <table class='admin_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('store_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('user_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('is_approved', 'ASC');" title="Approved"><?php echo $this->translate("A") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('featured', 'ASC');" title="Featured"><?php echo $this->translate("F") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('sponsored', 'ASC');" title="Sponsored"><?php echo $this->translate("S") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('hot', 'ASC');" title="Hot"><?php echo $this->translate("H") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('verified', 'ASC');" title="Verified"><?php echo $this->translate("V") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('offtheday', 'ASC');" title="Of the Day"><?php echo $this->translate("OTD") ?></a></th>
            <?php if(ESTOREPACKAGE == 1){ ?>
              <th><?php echo $this->translate("Package"); ?></th>
              <th><?php echo $this->translate("Price"); ?></th>
              <th><?php echo $this->translate("Package Expiration Date"); ?></th>
            <?php } ?>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $item): ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->store_id;?>' value="<?php echo $item->store_id; ?>" /></td>
            <td><?php echo $item->store_id ?></td>
            <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),16)), array('title' => $item->getTitle(), 'target' => '_blank')) ?></td>
            <td><?php echo $this->htmlLink($item->getOwner()->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getOwner()->getTitle(),16)), array('title' => $this->translate($item->getOwner()->getTitle()), 'target' => '_blank')) ?></td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1):?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'approved', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unapprove')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'approved', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Approve')))) ?>
              <?php endif; ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){?>
                <?php if($item->featured == 1):?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
                <?php endif; ?>
              <?php }else{ ?>
                  -
              <?php } ?> 
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){?>
                <?php if($item->sponsored == 1):?>
                 <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'sponsored', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'sponsored', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
                <?php endif; ?> 
              <?php }else{ ?>
                  -
              <?php } ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){?>
                <?php if($item->hot == 1):?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'hot', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Hot')))) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'hot', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Hot')))) ?>
                <?php endif; ?> 
              <?php }else{ ?>
                  -
              <?php } ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){?>
                <?php if($item->verified == 1): ?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'verify', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Verified')))) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'verify', 'id' => $item->store_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Verified')))) ?>
                <?php endif; ?> 
              <?php }else{ ?>
                  -
              <?php } ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){?>
                <?php if(strtotime($item->enddate) < strtotime(date('Y-m-d')) && $item->offtheday == 1):?>
                  <?php Engine_Api::_()->getDbTable('stores', 'estore')->update(array('offtheday' => 0,'startdate' =>'',
                            'enddate' =>''), array("store_id = ?" => $item->store_id));?>
                  <?php $itemofftheday = 0;?>
                <?php else:?>
                  <?php $itemofftheday = $item->offtheday; ?>
                <?php endif;?>
                <?php if($itemofftheday == 1):?>  
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->store_id, 'type' => 'stores', 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Store of the Day'))), array('class' => 'smoothbox')); ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->store_id, 'type' => 'stores', 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Store of the Day'))), array('class' => 'smoothbox')) ?>
                <?php endif; ?>
              <?php }else{ ?>
                  -
              <?php } ?>
            </td>
            <?php if(ESTOREPACKAGE == 1):?>
              <?php $package = $item->getPackage();?>
              <td><a href="javascript:;"><?php echo $package->getTitle(); ?></a></td>
              <td>
                <?php if($package->price < 1):?>
                  <?php echo "FREE";?>
                <?php else:?>
                  <?php $currentCurrency = Engine_Api::_()->estorepackage()->getCurrentCurrency();?>
                  <?php echo $package->getPackageDescription();?>
                <?php endif;?>
              </td>
              <td>
                <?php if($package->price < 1):?>
                  <?php echo "Never Expires";?>
                <?php else:?> 
                  <?php $transaction = $item->getTransaction();?>
                  <?php if(!$transaction):?>
                    <?php if($item->orderspackage_id):?>
                      <?php $table = Engine_Api::_()->getDbTable('transactions','estorepackage');?>
                      <?php $tableName = $table->info('name');?>
                      <?php $select = $table->select()->from($tableName)->where('orderspackage_id =?',$item->orderspackage_id)->where('gateway_profile_id !=?','')->where('state = "pending" || state = "complete" || state = "okay" || state = "active"')->limit(1);?>
                      <?php $transaction =  $table->fetchRow($select);?>
                      <?php if($transaction):?>
                        <?php echo $transaction->expiration_date; ?>
                      <?php else:?>
                        <?php echo "Unlimited";?>
                      <?php endif;?>
                    <?php else:?>
                     <?php echo "Unlimited";?>	
                    <?php endif;?>
                  <?php else:?>
                     <?php echo $transaction->expiration_date; ?>
                  <?php endif;?>
                <?php endif;?>
              </td>
            <?php endif;?>
            <td><?php echo $item->creation_date ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'view', 'id' => $item->store_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'change-owner', 'id' => $item->store_id), $this->translate("Change Owner"), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink($item->getHref(), $this->translate("View"), array('target' => '_blank')); ?>
              |
              <?php echo $this->htmlLink(array('route' => 'estore_dashboard', 'store_id' => $item->custom_url), $this->translate('Edit'), array('target'=> "_blank")) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'admin-manage', 'action' => 'delete', 'type' => 'stores', 'id' => $item->store_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <br />
    <div class='buttons'>
      <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
  </form>
  <br/>
  <div>
    <?php echo $this->paginationControl($this->paginator,null,null,$this->urlParams); ?>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no stores created by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>
<script type="text/javascript">
  function showSubCategory(cat_id,selectedId) {
    var selected;
    if(selectedId != ''){
      var selected = selectedId;
    }
    var url = en4.core.baseUrl + 'estore/ajax/subcategory/category_id/' + cat_id;
    en4.core.request.send(new Request.HTML({
      url: url,
      data: {
        'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "none";
            $('subcat_id').innerHTML = '';
          }
        }
      }
    }));
  }
function showSubSubCategory(cat_id,selectedId) {
    var selected;
    if(selectedId != ''){
      var selected = selectedId;
    }
    var url = en4.core.baseUrl + 'estore/ajax/subsubcategory/subcategory_id/' + cat_id;
    en4.core.request.send(new Request.HTML({
      url: url,
      data: {
        'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "inline-block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
        } else {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }));
  }
  window.addEvent('domready', function() {
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
  });
  window.addEvent('load', function() {
  $('subcat_id').value = '13';
       });
</script>
