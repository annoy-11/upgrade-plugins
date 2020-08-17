<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessveroth
 * @package    Sesbusinessveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<?php if( count($this->subNavigation) ): ?>
  <div class='sesbasic-admin-sub-tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
  </div>
<?php endif; ?>
<h3>Businesses Verification Requests</h3>
<p>
  <?php echo $this->translate('This page lists all the business verification requests made on your website which are waiting for admin approval. From here, you can take necessary action by approving, rejecting or deleting requests. Entering criteria into the filter fields will help you find specific request. Leaving the filter fields blank will show all the request on your website awaiting your action.<br /><br />Once an action is taken, the request will be removed from this business.<br /><br />Approved businesses will display in the "Manage Verified Businesses" section.'); ?>
</p>
<br />
<?php $baseURL = $this->layout()->staticBaseUrl;?>
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
</script>

<div class='admin_search sesbasic_search_form' style="margin-bottom:15px;">
  <?php echo $this->formFilter->render($this) ?>
</div>
<?php if(count($this->paginator) > 0):?>
<div class='sesbasic_search_result'>
  <?php $count = $this->paginator->getTotalItemCount() ?>
  <?php echo $this->translate(array("%s business verification request found.", "%s business verification requests found.", $count),
      $this->locale()->toNumber($count)) ?>
</div>
<div class="sesbasic_search_result">
  <?php echo $this->paginationControl($this->paginator, null, null, array(
    'businessAsQuery' => true,
    'query' => $this->formValues,
    //'params' => $this->formValues,
  )); ?>
</div>
<div class="admin_table_form sesbusinessveroth_manage_requests">
<form>
  <table class='admin_table'>
    <thead>
      <tr>
        <th><?php echo $this->translate("ID") ?></th>
        <th><?php echo $this->translate("Business Title") ?></th>
        <th><?php echo $this->translate("Verified By") ?></th>
        <th><?php echo $this->translate("Date") ?></th>
        <th style='width: 40%;'><?php echo $this->translate("Comments") ?></th>
        <th style='width: 10%;'><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ):

          $poster = $this->item('user', $item->poster_id);
          $resource = $this->item('businesses', $item->resource_id);
          ?>
          <tr>
            <td><?php echo $item->verification_id ?></td>
            <td class='admin_table_bold'>
              <?php echo $this->htmlLink($resource->getHref(), $this->string()->truncate($resource->getTitle(), 16), array('target' => '_blank'))?>
            </td>
            <td class='admin_table_user'><?php echo $this->htmlLink($poster->getHref(), $this->string()->truncate($poster->getTitle(), 16), array('target' => '_blank'))?></td>
            <td>
              <?php echo $item->creation_date; ?>
            </td>
            <td>
              <?php echo $item->description; ?>
            </td>
            <td class='admin_table_options'>
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'approve', 'verification_id' => $item->verification_id));?>'>
                <?php echo $this->translate("Approve") ?>
              </a>
              |
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'reject', 'verification_id' => $item->verification_id));?>'>
                <?php echo $this->translate("Reject") ?>
              </a>
              |
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'delete', 'verification_id' => $item->verification_id));?>'>
                <?php echo $this->translate("Delete") ?>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <br />
</form>
</div>
<?php else:?>
<div class="tip">
  <span>
    <?php echo "Currently, there are no requests to be approved.";?>
  </span>
</div>
<?php endif;?>
