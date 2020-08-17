<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: speakers.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
if(!$this->is_search_ajax):
if(!$this->is_ajax):
echo $this->partial('dashboard/left-bar.tpl', 'sesevent', array('event' => $this->event));?>
<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
  <?php endif; endif;  ?>
  <?php if(!$this->is_search_ajax): ?>
    <div class="sesbasic_dashboard_content_header sesbasic_clearfix">
      <h3><?php echo $this->translate('Manage Speaker') ?></h3>
    </div>
    <div class="sesbasic_clearfix sesevent_dashboard_btns rightT">
      <?php echo $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'add-admin-speaker', 'event_id' => $this->event->event_id, 'type' => 'eventspeaker'), $this->translate("My Created Speaker"), array('class' => 'smoothbox fa fa-plus')) ?>      
      <?php echo $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'add-admin-speaker', 'event_id' => $this->event->event_id, 'type' => 'admin'), $this->translate("Add Admin Created Speaker"), array('class' => 'smoothbox fa fa-plus')) ?>
      <?php echo $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'add-admin-speaker', 'event_id' => $this->event->event_id, 'type' => 'sitemember'), $this->translate("Add Site Member as Speaker"), array('class' => 'smoothbox fa fa-plus')) ?>
      <?php echo $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'add-events-speaker', 'event_id' => $this->event->event_id, 'type' => 'eventspeaker'), $this->translate("Add Speaker"), array('class' => 'smoothbox fa fa-plus')) ?>
  	</div>
  <?php endif;?>
  <div id="sesevent_manage_tickets_content">
    <?php if( count($this->paginator) > 0): ?>
    <div class="sesbasic_dashboard_table sesbasic_bxs">
      <form method="post" >
        <table>
          <thead>
            <tr>
              <th><?php echo $this->translate("Name") ?></th>
              <th><?php echo $this->translate("Email") ?></th>
              <th class="centerT"><?php echo $this->translate("Enabled") ?></th>
              <th><?php echo $this->translate("Option") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->paginator as $item): 
           // if($item->type == 'admin' || $item->type == 'eventspeaker'):
	            $items = Engine_Api::_()->getItem('seseventspeaker_speakers', $item->speaker_id);
	         // elseif($item->type == 'sitemember'):
	          //  $items = Engine_Api::_()->getItem('user', $item->speaker_id);
           // endif;
            ?>
            <tr>
              <td>
              <?php //if($item->type == 'admin' || $item->type == 'eventspeaker'): ?>
	              <?php echo $this->htmlLink($items->getHref(array('event_id' => $this->event->event_id)), $this->string()->truncate($items->name, 20), array('target' => '_blank', 'title' => $items->getTitle()))?>
              <?php //elseif($item->type == 'sitemember'): ?>
                <?php //echo $this->htmlLink($items->getHref(array('event_id' => $this->event->event_id)), $this->string()->truncate($items->getTitle(), 20), array('target' => '_blank', 'title' => $items->getTitle()))?>
              <?php //endif; ?>
              </td>
              <td>
              <?php if($items->email): ?>
	              <?php echo $items->email; ?>
	            <?php else: ?>
		            <?php echo "---"; ?>
	            <?php endif; ?>
              </td>
	            <td class="centerT">
		            <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'enabled', 'eventspeaker_id' => $item->eventspeaker_id, 'event_id' => $this->event->event_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'enabled', 'eventspeaker_id' => $item->eventspeaker_id, 'event_id' => $this->event->event_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
	            </td>
              <td>
                <?php if($item->type == 'eventspeaker'): ?>
	                <?php echo $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'edit-events-speaker', 'event_id' => $this->event->event_id, 'eventspeaker_id' => $item->eventspeaker_id, 'type' => $item->type, 'speaker_id' => $item->speaker_id), $this->translate("Edit"), array('class' => 'smoothbox ')) ?> | 
                <?php endif; ?>
                
		            <?php echo $this->htmlLink(array('route' => 'seseventspeaker_dashboard', 'action' => 'delete-speaker', 'event_id' => $this->event->event_id, 'eventspeaker_id' => $item->eventspeaker_id, 'type' => $item->type, 'speaker_id' => $item->speaker_id), $this->translate("Delete"), array('class' => 'smoothbox ')) ?>
	            </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </form>
    </div>
    <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate("No speaker added yet.") ?>
      </span>
    </div>
    <?php endif; ?>
  </div>
  <?php if(!$this->is_search_ajax): 
  if(!$this->is_ajax): ?>
</div>
</div>
</div>
<?php endif; endif; ?>