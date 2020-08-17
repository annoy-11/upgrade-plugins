<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
			  <div class='settings sesbasic_admin_form'>
					<script type="text/javascript">
					function multiDelete()
					{
					  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected offers?") ?>");
					}
					function selectAll()
					{
					  var i;
					  var multidelete_form = $('multidelete_form');
					  var inputs = multidelete_form.elements;
					  for (i = 1; i < inputs.length; i++) {
					    if (!inputs[i].disabled) {
					      inputs[i].checked = inputs[0].checked;
					    }
					  }
					}

					 function killProcess(pageoffer_id) {
					    (new Request.JSON({
					      'format': 'json',
					      'url' : '<?php echo $this->url(array('module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'kill'), 'default', true) ?>',
					      'data' : {
					        'format' : 'json',
					        'pageoffer_id' : pageoffer_id
					      },
					      'onRequest' : function(){
					        $$('input[type=radio]').set('disabled', true);
					      },
					      'onSuccess' : function(responseJSON, responseText)
					      {
					        window.location.reload();
					      }
					    })).send();

					  }
					</script>

					<h3><?php echo $this->translate("Manage Offers") ?></h3>
					<p>
						<?php echo $this->translate('This page lists all of the offers your users have created in Pages on your website. You can use this page to monitor these offers and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific offer. Leaving the filter fields blank will show all the offers on your social network.<br><br> Below, you can also choose any number of offers as Offers of the Day, Featured, Hot and New.') ?>
					</p>
					<br />
					<div class='admin_search sesbasic_search_form'>
					  <?php echo $this->formFilter->render($this) ?>
					</div>
					<br />
					<?php if( count($this->paginator) ): ?>
					  <div class="sesbasic_search_reasult">
					    <?php echo $this->translate(array('%s offer found.', '%s offers found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
					  </div>
					  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
					  <div class="admin_table_form" style="overflow:auto;">
					    <table class='admin_table'>
					      <thead>
					        <tr>
					          <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
					          <th class='admin_table_short'>ID</th>
                    <th><?php echo $this->translate("Page") ?></th>
					          <th><?php echo $this->translate("Title") ?></th>
					          <th><?php echo $this->translate("Owner") ?></th>
					          <th align="center" title="Featured"><?php echo $this->translate('F') ?></th>
					          <th align="center" title="Hot"><?php echo $this->translate('H') ?></th>
					          <th align="center" title="New"><?php echo $this->translate('N') ?></th>
					          <th align="center" title="Of the Day"><?php echo $this->translate("OTD") ?></th>
					          <th><?php echo $this->translate("Options") ?></th>
					        </tr>
					      </thead>
					      <tbody>
					        <?php foreach ($this->paginator as $item): 
                  	$page = Engine_Api::_()->getItem('sespage_page',$item->parent_id);
                    if(!$page)
                    	continue;
                  ?>
					          <tr>
					            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->pageoffer_id;?>' value='<?php echo $item->pageoffer_id ?>' /></td>
					            <td><?php echo $item->getIdentity() ?></td>
                      <td><?php echo  $this->htmlLink($page->getHref(), $page->getTitle()); ?></td>
					            <td><?php echo  $this->htmlLink($item->getHref(), $item->getTitle()); ?></td>
					            <td><?php echo $this->htmlLink($item->getHref(), $item->getOwner()); ?></td>
					            <td class="admin_table_centered">
					              <?php echo $item->featured == 1 ?   $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->pageoffer_id),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->pageoffer_id),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ; ?>   
					              </td>
					              <td class="admin_table_centered">
					                <?php echo $item->hot == 1 ? $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'hot', 'id' => $item->pageoffer_id,'status' =>0),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Hot')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'hot', 'id' => $item->pageoffer_id),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Hot'))))  ; ?>       
					              </td>
					              <td class="admin_table_centered">
					                <?php echo $item->new == 1 ? $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'new', 'id' => $item->pageoffer_id,'status' =>0),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as New')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'new', 'id' => $item->pageoffer_id),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark New'))))  ; ?>       
					              </td>
												<td class="admin_table_centered">
														<?php if(strtotime($item->enddate) < strtotime(date('Y-m-d')) && $item->offtheday == 1):?>
															<?php Engine_Api::_()->getDbTable('pageoffers', 'sespageoffer')->update(array('offtheday' => 0,'startdate' =>'', 'enddate' =>''), array("pageoffer_id = ?" => $item->pageoffer_id));?>
															<?php $itemofftheday = 0;?>
														<?php else:?>
															<?php $itemofftheday = $item->offtheday; ?>
														<?php endif;?>
														<?php if($itemofftheday == 1):?>  
															<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->pageoffer_id, 'type' => 'pageoffer', 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Offer of the Day'))), array('class' => 'smoothbox')); ?>
														<?php else: ?>
															<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->pageoffer_id, 'type' => 'pageoffer', 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Offer of the Day'))), array('class' => 'smoothbox')) ?>
														<?php endif; ?>
												</td>
					            <td>
					              <a href="<?php echo $item->getHref(); ?>" target = "_blank" ><?php echo $this->translate("View") ?></a>
					              |
					              <?php echo $this->htmlLink(array('route' => 'sespageoffer_general','module' => 'sespageoffer','controller' => 'index','action' => 'edit','parent_id' => $item->parent_id,'pageoffer_id' => $item->pageoffer_id), $this->translate('Edit'), array('target'=> "_blank")) ;?>
					              |
					              <?php echo $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespageoffer', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->pageoffer_id),
					                  $this->translate("Delete"),
					                  array('class' => 'smoothbox')) ?>
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
					  <br />
					  <div>
					    <?php echo $this->paginationControl($this->paginator); ?>
					  </div>
					<?php else: ?>
					  <br />
					  <div class="tip">
					    <span>
					      <?php echo $this->translate("There are no offers create by your members yet.") ?>
					    </span>
					  </div>
					<?php endif; ?>
				</div>
			</div>
		</div>
  </div>
</div>
