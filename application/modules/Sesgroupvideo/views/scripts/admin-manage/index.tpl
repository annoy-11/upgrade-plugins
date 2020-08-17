<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>
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
					  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected videos?") ?>");
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

					 function killProcess(video_id) {
					    (new Request.JSON({
					      'format': 'json',
					      'url' : '<?php echo $this->url(array('module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'kill'), 'default', true) ?>',
					      'data' : {
					        'format' : 'json',
					        'video_id' : video_id
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

					<h3><?php echo $this->translate("Manage Videos") ?></h3>
					<p>
						<?php echo $this->translate('This page lists all of the videos your users have created in Groups on your website. You can use this group to monitor these videos and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific video. Leaving the filter fields blank will show all the videos on your social network.<br><br>
Below, you can also choose any number of videos as Videos of the Day, Featured, Sponsored or Hot.') ?>
					</p>
					<br />
					<div class='admin_search sesbasic_search_form'>
					  <?php echo $this->formFilter->render($this) ?>
					</div>
					<br />
					<?php if( count($this->paginator) ): ?>
					  <div class="sesbasic_search_reasult">
					    <?php echo $this->translate(array('%s video found.', '%s videos found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
					  </div>
					  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
					  <div class="admin_table_form" style="overflow:auto;">
					    <table class='admin_table'>
					      <thead>
					        <tr>
					          <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
					          <th class='admin_table_short'>ID</th>
                    <th><?php echo $this->translate("Group") ?></th>
					          <th><?php echo $this->translate("Title") ?></th>
					          <th><?php echo $this->translate("Owner") ?></th>
					          <th><?php echo $this->translate("Type") ?></th>
					          <th><?php echo $this->translate("State") ?></th>
					          <th align="center" title="Featured"><?php echo $this->translate('F') ?></th>
					          <th align="center" title="Sponsored"><?php echo $this->translate('S') ?></th>
					          <th align="center" title="Hot"><?php echo $this->translate('H') ?></th>
					          <th align="center" title="Of the Day"><?php echo $this->translate("OTD") ?></th>
					           <th align="center"><?php echo $this->translate("Status") ?></th>
					          <th><?php echo $this->translate("Options") ?></th>
					        </tr>
					      </thead>
					      <tbody>
					        <?php foreach ($this->paginator as $item): 
                  	$group = Engine_Api::_()->getItem('sesgroup_group',$item->parent_id);
                    if(!$group)
                    	continue;
                  ?>
					        <?php $statusVideo = $item->approve;  ?>
					          <tr>
					            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->video_id;?>' value='<?php echo $item->video_id ?>' /></td>
					            <td><?php echo $item->getIdentity() ?></td>
                      <td><?php echo  $this->htmlLink($group->getHref(), $group->getTitle()); ?></td>
					            <td><?php echo  $this->htmlLink($item->getHref(), $item->getTitle()); ?></td>
					            <td><?php echo $this->htmlLink($item->getHref(), $item->getOwner()); ?></td>
					            <td>
					              <?php
					                switch( $item->type ) {
					                  case 1:
					                    $type = $this->translate("YouTube");
					                    break;
					                  case 2:
					                    $type = $this->translate("Vimeo");
					                    break;
					                  case 3:
					                    $type = $this->translate("Uploaded");
					                    break;
					                  case 4:
					                    $type = $this->translate("Dailymotion");
					                    break;
					                  default:
					                    $type = $this->translate("Video Swipper Video");
					                    break;
					                }
					                echo $type;
					              ?>
					            </td>
					            <td>
					              <?php
					                switch ($item->status){
					                  case 0:
					                    $status = $this->translate("queued");
					                    break;
					                  case 1:
					                    $status = $this->translate("ready");
					                    break;
					                  case 2:
					                    $status = $this->translate("processing");
					                    break;
					                  default:
					                    $status = $this->translate("failed");
					                }
					                echo $status;
					              ?>
					              <?php if($item->status == 2):?>
					              (<a href="javascript:void(0);" onclick="javascript:killProcess('<?php echo $item->video_id?>');">
					                <?php echo $this->translate("end"); ?>
					              </a>)
					              <?php endif;?>
					            </td>
					            <td class="admin_table_centered">
					              <?php if($statusVideo){ ?>
					              <?php echo $item->is_featured == 1 ?   $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'feature-sponsored', 'id' => $item->video_id,'status' =>0,'category' =>'featured','param'=>'videos'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'feature-sponsored', 'id' => $item->video_id,'status' =>1,'category' =>'featured','param'=>'videos'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ; ?>
					              <?php }else{ echo "-";} ?>    
					              </td>
					              <td class="admin_table_centered">
					                <?php if($statusVideo){ ?>
					                <?php echo $item->is_sponsored == 1 ? $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'feature-sponsored', 'id' => $item->video_id,'status' =>0,'category' =>'sponsored','param'=>'videos'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'feature-sponsored', 'id' => $item->video_id,'status' =>1,'category' =>'sponsored','param'=>'videos'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored'))))  ; ?>
					                <?php }else{ echo "-";} ?>        
					              </td>
					             <td class="admin_table_centered">
					               <?php if($statusVideo){ ?>
					                <?php echo $item->is_hot == 1 ? $this->htmlLink(array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'hot', 'id' => $item->video_id,'status' =>0),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Hot')))) : $this->htmlLink(array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'hot', 'id' => $item->video_id,'status' =>1),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Hot'))))  ; ?>
					                 <?php }else{ echo "-";} ?> 
					                </td>
					                <td class="admin_table_centered">
					                <?php if($statusVideo){ ?>
					                <?php if(strtotime($item->endtime) < strtotime(date('Y-m-d')) && $item->offtheday == 1){ 
					                    Engine_Api::_()->getDbtable('videos', 'sesgroupvideo')->update(array(
					                        'offtheday' => 0,
					                        'starttime' =>'',
					                        'endtime' =>'',
					                      ), array(
					                        "video_id = ?" => $item->video_id,
					                      ));
					                      $itemofftheday = 0;
					               }else
					                $itemofftheday = $item->offtheday; ?>
					              <?php if($itemofftheday == 1):?>  
					                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->video_id, 'type' => 'groupvideo', 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Video of the Day'))), array('class' => 'smoothbox')); ?>
					              <?php else: ?>
					                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->video_id, 'type' => 'groupvideo', 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Video of the Day'))), array('class' => 'smoothbox')) ?>
					              <?php endif; ?>
					               <?php }else{ echo "-";} ?> 
					            </td>
					            <td class="admin_table_centered">
					              <?php echo $item->approve == 1 ? $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'approve', 'id' => $item->video_id,'approve' =>0),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Approved')))) : $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'approve', 'id' => $item->video_id,'approve' =>1),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Approved'))))  ; ?>
					            
					            </td>
					            <td>
					              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'view', 'type'=> 'groupvideo', 'id' => $item->video_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
					              |
					              <a href="<?php echo $item->getHref(); ?>" target = "_blank" ><?php echo $this->translate("View") ?></a>
					              |
					              <?php echo $this->htmlLink(array('route' => 'sesgroupvideo_general','module' => 'sesgroupvideo','controller' => 'index','action' => 'edit','video_id' => $item->video_id), $this->translate('Edit'), array('target'=> "_blank")) ;?>
					              |
					              <?php echo $this->htmlLink(
					                  array('route' => 'default', 'module' => 'sesgroupvideo', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->video_id),
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
					      <?php echo $this->translate("There are no videos posted by your members yet.") ?>
					    </span>
					  </div>
					<?php endif; ?>
				</div>
			</div>
		</div>
  </div>
</div>
