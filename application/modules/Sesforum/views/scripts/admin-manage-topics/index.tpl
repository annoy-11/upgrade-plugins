<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected topic entries?');?>");
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
<?php include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic-form">
	<div>
  	<div class="sesbasic-form-cont">
      <h3><?php echo $this->translate('Manage Topics'); ?></h3>
      <p>
        <?php echo $this->translate("This page lists all of the topics your users have posted in the forums. You can use this page to monitor these topics and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific topic entries. Leaving the filter fields blank will show all the topic entries on your social network.") ?>
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
          <?php echo $this->translate(array('%s topic found.', '%s topics found.', $counter), $this->locale()->toNumber($counter)) ?>
        </div>
      <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
      <table class='admin_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('topic_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><?php echo $this->translate("Forum Name") ?></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('user_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
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
                <?php $forum = Engine_Api::_()->getItem('sesforum_forum', $item->forum_id); ?>
                <?php if(strlen($forum->getTitle()) > 16):?>
                  <?php $title = mb_substr($forum->getTitle(),0,16).'...';?>
                  <?php echo $this->htmlLink($forum->getHref(),$title,array('title'=>$forum->getTitle()));?>
                <?php else: ?>
                  <?php echo $this->htmlLink($forum->getHref(),$forum->getTitle(),array('title'=>$forum->getTitle())  ) ?>
                <?php endif;?>
              </td>
              <td><a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $item->getOwner()->getTitle() ?></a></td>
              <td><?php echo $item->creation_date ?></td>
              <td>
                <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesforum', 'controller' => 'manage-topics', 'action' => 'delete', 'id' => $item->topic_id), $this->translate("delete"), array('class' => 'smoothbox')) ?>
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
            <?php echo $this->translate("There are no topic entries by your members yet.") ?>
          </span>
        </div>
      <?php endif; ?>
		</div>
	</div>
</div>
