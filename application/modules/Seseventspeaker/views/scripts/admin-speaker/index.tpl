<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesevent/views/scripts/dismiss_message.tpl';?>

<?php $baseURL = $this->layout()->staticBaseUrl; ?>

<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
      <div class='clear settings'>
        <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()">
          <div>
            <h3><?php echo $this->translate("Manage Speakers"); ?></h3>
            <p><?php echo $this->translate('Here, you can speakers.') ?></p>
            <br />
            <div>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'add-speaker', 'type' => 'admin'), $this->translate('Add New Speaker'), array('class' => 'sesbasic_icon_add buttonlink'))
              ?><br/>
            </div><br />
            <?php if(count($this->paginator) > 0):?>
              <div class="sesevent_manage_speakers">
                <div class="sesevent_manage_speakers_head">
                  <div style="width:5%">
                    <input onclick="selectAll()" type='checkbox' class='checkbox'>
                  </div>
                  <div style="width:40%">
                    <?php echo "Display Name";?>
                  </div>
                  <div class="admin_table_centered" style="width:10%">
                    <?php echo "Featured";?>
                  </div>
                  <div class="admin_table_centered" style="width:10%">
                    <?php echo "Sponsored";?>
                  </div>
                  <div class="admin_table_centered" style="width:10%">
                    <?php echo "Of the Day";?>
                  </div>
                  <div class="admin_table_centered" style="width:10%">
                    <?php echo "Status";?>
                  </div>
                  <div style="width:15%" class="">
                    <?php echo "Options";?>
                  </div>   
                </div>
                <ul class="sesevent_manage_speakers_list">
                  <?php foreach ($this->paginator as $item):
                  $user = $this->item('user', $item->user_id); ?>
                    <li class="item_label">
                      <input type='hidden'  name='order[]' value='<?php echo $item->speaker_id; ?>'>
                      <div style="width:5%;">
                        <input name='delete_<?php echo $item->speaker_id ?>_<?php echo $item->speaker_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->speaker_id ?>_<?php echo $item->speaker_id ?>"/>
                      </div>
                      <div style="width:40%;">
                        <?php echo $this->htmlLink($item->getHref(), $this->string()->truncate($item->name, 20), array('target' => '_blank', 'title' => $item->getTitle()))?>
                      </div>
                      <div class="admin_table_centered" style="width:10%;">
                        <?php echo ( $item->featured ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'featured', 'speaker_id' => $item->speaker_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Unmark as Featured'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'featured', 'speaker_id' => $item->speaker_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Mark Featured')))) ) ?>
                      </div>
                      <div class="admin_table_centered" style="width:10%;">
                        <?php echo ( $item->sponsored ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'sponsored', 'speaker_id' => $item->speaker_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Unmark as Sponsored'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'sponsored', 'speaker_id' => $item->speaker_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Mark Sponsored')))) ) ?>
                      </div>
                      <div class="admin_table_centered" style="width:10%;">
                        <?php if($item->offtheday == 1):?>  
                          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'oftheday', 'id' => $item->speaker_id, 'type' => 'sesevent_nonteam', 'param' => 0), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Team Member of the Day'))), array('class' => 'smoothbox')); ?>
                        <?php else: ?>
                          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'oftheday', 'id' => $item->speaker_id, 'type' => 'sesevent_nonteam', 'param' => 1), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Team Member of the Day'))), array('class' => 'smoothbox')) ?>
                        <?php endif; ?>
                      </div>
                      <div class="admin_table_centered" style="width:10%;">
                        <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'enabled', 'speaker_id' => $item->speaker_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'enabled', 'speaker_id' => $item->speaker_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                      </div>
                      <div style="width:15%;">
                        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'edit', 'speaker_id' => $item->speaker_id, 'type' => 'admin'), $this->translate('Edit'), array('class' => '')) ?> |
                          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'delete', 'speaker_id' => $item->speaker_id), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
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
                  <?php echo "There are no speaker members yet.";?>
                </span>
              </div>
            <?php endif;?>
          </div>
        </form>
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
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected non site speaker?")) ?>');
  }
</script>