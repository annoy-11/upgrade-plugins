<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
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
					  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected notes?") ?>");
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

					 function killProcess(pagenote_id) {
					    (new Request.JSON({
					      'format': 'json',
					      'url' : '<?php echo $this->url(array('module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'kill'), 'default', true) ?>',
					      'data' : {
					        'format' : 'json',
					        'pagenote_id' : pagenote_id
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

					<h3><?php echo $this->translate("Manage Notes") ?></h3>
					<p>
						<?php echo $this->translate('This page lists all of the notes your users have created in Pages on your website. You can use this page to monitor these notes and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific note. Leaving the filter fields blank will show all the notes on your social network.<br><br> Below, you can also choose any number of notes as Notes of the Day, Featured or Sponsored.') ?>
					</p>
					<br />
					<div class='admin_search sesbasic_search_form'>
					  <?php echo $this->formFilter->render($this) ?>
					</div>
					<br />
					<?php if( count($this->paginator) ): ?>
					  <div class="sesbasic_search_reasult">
					    <?php echo $this->translate(array('%s note found.', '%s notes found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
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
					          <th align="center" title="Sponsored"><?php echo $this->translate('S') ?></th>
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
					            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->pagenote_id;?>' value='<?php echo $item->pagenote_id ?>' /></td>
					            <td><?php echo $item->getIdentity() ?></td>
                      <td><?php echo  $this->htmlLink($page->getHref(), $page->getTitle()); ?></td>
					            <td><?php echo  $this->htmlLink($item->getHref(), $item->getTitle()); ?></td>
					            <td><?php echo $this->htmlLink($item->getHref(), $item->getOwner()); ?></td>
					            <td class="admin_table_centered">
					              <?php echo $item->featured == 1 ?   $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->pagenote_id),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'featured', 'id' => $item->pagenote_id),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ; ?>   
					              </td>
					              <td class="admin_table_centered">
					                <?php echo $item->sponsored == 1 ? $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'sponsored', 'id' => $item->pagenote_id,'status' =>0),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'sponsored', 'id' => $item->pagenote_id),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored'))))  ; ?>       
					              </td>
												<td class="admin_table_centered">
														<?php if(strtotime($item->enddate) < strtotime(date('Y-m-d')) && $item->offtheday == 1):?>
															<?php Engine_Api::_()->getDbTable('pages', 'sespagenote')->update(array('offtheday' => 0,'startdate' =>'', 'enddate' =>''), array("pagenote_id = ?" => $item->pagenote_id));?>
															<?php $itemofftheday = 0;?>
														<?php else:?>
															<?php $itemofftheday = $item->offtheday; ?>
														<?php endif;?>
														<?php if($itemofftheday == 1):?>  
															<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->pagenote_id, 'type' => 'pagenote', 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Note of the Day'))), array('class' => 'smoothbox')); ?>
														<?php else: ?>
															<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->pagenote_id, 'type' => 'pagenote', 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Note of the Day'))), array('class' => 'smoothbox')) ?>
														<?php endif; ?>
												</td>
					            <td>
					              <a href="<?php echo $item->getHref(); ?>" target = "_blank" ><?php echo $this->translate("View") ?></a>
					              |
					              <?php echo $this->htmlLink(array('route' => 'sespagenote_general','module' => 'sespagenote','controller' => 'index','action' => 'edit','parent_id' => $item->parent_id,'pagenote_id' => $item->pagenote_id), $this->translate('Edit'), array('target'=> "_blank")) ;?>
					              |
					              <?php echo $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sespagenote', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->pagenote_id),
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
					      <?php echo $this->translate("There are no notes create by your members yet.") ?>
					    </span>
					  </div>
					<?php endif; ?>
				</div>
			</div>
		</div>
  </div>
</div>
