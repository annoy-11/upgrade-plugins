<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected crowdfunding entries?');?>");
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

<?php include APPLICATION_PATH .  '/application/modules/Sescrowdfunding/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate('Manage Campaigns'); ?></h3>
<p>
  <?php echo $this->translate("This page lists all crowdfunding campaigns that your users have created and allows you to monitor their campaign/activity and delete offensive materials if necessary. Applying required criteria into the filter fields will help you to find specific crowdfunding. Leaving the filter fields blank will show all the crowdfunding entries on your social network.") ?>
</p>

<br />

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>	
<br />	
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?>
<?php if( count($this->paginator) ): ?>
	<div class="sesbasic_search_reasult">
		<?php echo $this->translate(array('%s campaign found.', '%s campaigns found.', $counter), $this->locale()->toNumber($counter)) ?>
	</div>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
      <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('crowdfunding_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('owner_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
      
      <th align="center" title='<?php echo $this->translate("Featured") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('featured', 'ASC');"><?php echo $this->translate("F") ?></a></th>
      
      <th align="center" title='<?php echo $this->translate("Sponsored") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('sponsored', 'ASC');"><?php echo $this->translate("S") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Verified") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('verified', 'ASC');"><?php echo $this->translate("V") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Approved") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('approved', 'ASC');"><?php echo $this->translate("A") ?></a></th>

      <th align="center" title='<?php echo $this->translate("Of the Day") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('offtheday', 'ASC');"><?php echo $this->translate("OTD") ?></a></th>

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
					<?php if(strlen($item->getTitle()) > 16):?>
						<?php $title = mb_substr($item->getTitle(),0,16).'...';?>
						<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
					<?php else: ?>
						<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
					<?php endif;?>
				</td>
        <td>
          <a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $item->getOwner()->getTitle() ?></a>
        </td>
        <td class="admin_table_centered">
          <?php if($item->featured == 1):?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
          <?php endif; ?>
        </td>
        <td class="admin_table_centered">
          <?php if($item->sponsored == 1):?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'sponsored', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'sponsored', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
          <?php endif; ?>
        </td>
        <td class="admin_table_centered">
          <?php if($item->verified == 1):?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'verified', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Verified')))) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'verified', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Verified')))) ?>
          <?php endif; ?>
        </td>
        <td class="admin_table_centered">
          <?php if($item->approved == 1):?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'approved', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Approved')))) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'approved', 'id' => $item->crowdfunding_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Approved')))) ?>
          <?php endif; ?>
        </td>
        <td class="admin_table_centered">
          <?php 
//           if(strtotime($item->endtime) < strtotime(date('Y-m-d')) && $item->offtheday == 1){ 
//             Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->update(array(
//               'offtheday' => 0,
//               'starttime' =>'',
//               'endtime' =>'',
//             ), array(
//               "crowdfunding_id = ?" => $item->crowdfunding_id,
//             ));
//             $itemofftheday = 0;
//           } else
          $itemofftheday = $item->offtheday; ?>
          <?php if($itemofftheday == 1):?>  
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->crowdfunding_id, 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Campaign of the Day'))), array('class' => 'smoothbox')); ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->crowdfunding_id, 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Campaign of the Day'))), array('class' => 'smoothbox')) ?>
          <?php endif; ?>
        </td>
       
        <td><?php echo $item->creation_date ?></td>
        <td>
					<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'view','id' => $item->crowdfunding_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
          |
          <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'sescrowdfunding_dashboard', 'crowdfunding_id' => $item->custom_url), $this->translate('edit'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(
	  array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->crowdfunding_id),
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
      <?php echo $this->translate("There are no crowdfunding campaigns created on your site yet.") ?>
    </span>
  </div>
<?php endif; ?>
