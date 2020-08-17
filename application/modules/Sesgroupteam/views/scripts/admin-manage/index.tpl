<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
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
          <div class='clear settings'>
            <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'sesgroupteam', 'controller' => 'manage', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()">
              <div>
                <h3><?php echo $this->translate("Manage Group Team Members"); ?></h3>
                <p><?php echo $this->translate('Here, you can choose members of your website to be shown as Team Members.') ?></p>
                <br />
                <?php if(count($this->paginator) > 0):?>
                  <div class="sesgroupteam_manage_designations">
                    <div class="sesgroupteam_manage_designations_head">
                      <div style="width:5%">
                        <input onclick="selectAll()" type='checkbox' class='checkbox'>
                      </div>
                      <div style="width:20%">
                        <?php echo "Team Member Name";?>
                      </div>
                      <div style="width:25%">
                        <?php echo "Group Name";?>
                      </div>
                      <div style="width:35%">
                        <?php echo "Designation";?>
                      </div>
<!--                      <div class="admin_table_centered" style="width:10%">
                        <?php //echo "Status";?>
                      </div>-->
                      <div style="width:15%" class="">
                        <?php echo "Options";?>
                      </div>   
                    </div>
                    <ul class="sesgroupteam_manage_designations_list">
                      <?php foreach ($this->paginator as $item): ?>
                        <?php if($item->type == 'sitemember') { ?>
                          <?php $user = $this->item('user', $item->user_id); ?>
                        <?php } ?>
                        <li class="item_label" id="teams_<?php echo $item->team_id ?>">
                          <input type='hidden'  name='order[]' value='<?php echo $item->team_id; ?>'>
                          <div style="width:5%;">
                            <input name='delete_<?php echo $item->team_id ?>_<?php echo $item->team_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->team_id ?>_<?php echo $item->team_id ?>"/>
                          </div>
                          <div style="width:20%;">
                            <?php if($item->type == 'sitemember') { ?>
                              <?php echo $this->htmlLink($user->getHref(), $this->string()->truncate($user->getTitle(), 20), array('target' => '_blank', 'title' => $user->getTitle()))?>
                            <?php } else { ?>
                              <?php echo $this->string()->truncate($item->getTitle(), 20); ?>
                            <?php } ?>
                          </div>
                          <div style="width:25%;">
                            <?php $group = Engine_Api::_()->getItem('sesgroup_group', $item->group_id); ?>
                            <a href="<?php echo $group->getHref(); ?>"><?php echo $this->translate($group->getTitle()); ?></a>
                          </div>
                          <div style="width:35%;">
                            <?php if($item->designation_id && $item->designation): ?>
                              <?php echo $item->designation ?>
                            <?php else: ?>
                             <?php echo "---"; ?>
                            <?php endif; ?>
                          </div>
<!--                          <div class="admin_table_centered" style="width:10%;">
                            <?php //echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesgroupteam', 'controller' => 'manage', 'action' => 'enabled', 'team_id' => $item->team_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesgroupteam', 'controller' => 'manage', 'action' => 'enabled', 'team_id' => $item->team_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                          </div>-->
                          <div style="width:15%;">
                            <a href="<?php echo $item->getHref(); ?>">View</a>
                            |
                            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesgroupteam', 'controller' => 'manage', 'action' => 'delete', 'team_id' => $item->team_id), $this->translate('Remove'), array('class' => 'smoothbox')) ?>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                  <div class='buttons'>
                    <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
                  </div>
                <?php else:?>
                  <div class="tip">
                    <span>
                      <?php echo "There are no team members yet.";?>
                    </span>
                  </div>
                <?php endif;?>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
 
  function selectAll(){
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;

    for (i = 1; i < inputs.length - 1; i++) {
      if (!inputs[i].disabled) {
       inputs[i].checked = inputs[0].checked;
      }
    }
  }
  
  function multiDelete(){
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected site team?")) ?>');
  }
</script>
