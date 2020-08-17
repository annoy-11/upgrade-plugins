<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: photos.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sescrowdfunding/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
  function multiDelete()
  {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected photos ?');?>");
  }

  function selectAll()
  {
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length - 1; i++) {
      inputs[i].checked = inputs[0].checked;
    }
  }
</script>
<h3>Manage Photos</h3>
<p>This page lists all of the photos your users have uploaded in crowdfunding campaigns. You can use this page to monitor these photos and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific photo. Leaving the filter fields blank will show all the photos on your social network.<br /></p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s photo found.', '%s photos found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
    <table class='admin_table'>
      <thead>
        <tr>
          <th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
          <th class='admin_table_short'>ID</th>
          <th><?php echo $this->translate('Image') ?></th>
          <th><?php echo $this->translate('Crowdfunding Title') ?></th>
          <th><?php echo $this->translate('Owner') ?></th>
          <th><?php echo $this->translate('Options') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <?php $Crowdfunding = Engine_Api::_()->getItem('crowdfunding', $item->crowdfunding_id); ?>
        <tr>
          <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->photo_id;?>' value="<?php echo $item->photo_id ?>"/></td>
          <td><?php echo $item->getIdentity() ?></td>
          <td><img src="<?php echo $item->getPhotoUrl('thumb.normal'); ?>" style="height:75px; width:75px;"/></td>
          <?php $album = Engine_Api::_()->getItem('album',$item->album_id) ?>
          <td><a href="<?php echo $Crowdfunding->getHref(); ?>"><?php echo $Crowdfunding->getTitle() ?></a></td> 
          <td><?php echo $this->htmlLink($Crowdfunding->getHref(), $Crowdfunding->getOwner()); ?></td>
          <td>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage', 'action' => 'delete-photo', 'id' => $item->photo_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br/>
    <div class='buttons'>
      <button type='submit'> <?php echo $this->translate('Delete Selected') ?> </button>
    </div>
  </form>
  <br />
  <div class="clear"> <?php echo $this->paginationControl($this->paginator); ?> </div>
<?php else: ?>
  <div class="tip"> <span> <?php echo $this->translate("There are no photos .") ?> </span> </div>
<?php endif; ?>
