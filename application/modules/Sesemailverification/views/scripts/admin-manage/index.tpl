<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesemailverification/views/scripts/dismiss_message.tpl';?>
<h3>Manage Members for Email Verification</h3>
<p>
  <?php echo $this->translate("This page lists all the members of your website with the status of their email verification and account status. Entering criteria into the filter fields will help you find specific member. Leaving the filter fields blank will show all the members on your social network.<br />Below, you can mark a member as Verified (for verified email) / Unverified or Approved / Disapproved.") ?>
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

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<div class='admin_results'>
  <div>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s member found.", "%s members found.", $count),
        $this->locale()->toNumber($count)) ?>
  </div>
  <div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'pageAsQuery' => true,
      'query' => $this->formValues,
      //'params' => $this->formValues,
    )); ?>
  </div>
</div>

<br />
<?php if(count($this->paginator) > 0):?>
<div class="admin_table_form">
<form>
  <table class='admin_table'>
    <thead>
      <tr>
        <th style='width: 1%;'><a href="javascript:void(0);" onclick="javascript:changeOrder('user_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
        <th><a href="javascript:void(0);" onclick="javascript:changeOrder('displayname', 'ASC');"><?php echo $this->translate("Member Name") ?></a></th>
        <th><?php echo $this->translate("Email") ?></th>
        <th style='width: 1%;'><?php echo $this->translate("Verified Email") ?></th>
        <th style='width: 1%;'><?php echo $this->translate("Approved") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ):
          $user = $this->item('user', $item->user_id);
          ?>
          <tr>
            <td><?php echo $item->user_id ?></td>
            <td class='admin_table_bold'>
              <?php echo $this->htmlLink($user->getHref(),
                  $this->string()->truncate($user->getTitle(), 16),
                  array('target' => '_blank'))?>
            </td>
            <td><?php echo $item->email ?></td>
            <td class='admin_table_centered'>
              <?php $verification_id = Engine_Api::_()->getDbTable('verifications', 'sesemailverification')->rowExist($item->user_id); ?>
              <?php echo ( $item->sesemailverified ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemailverification', 'controller' => 'manage', 'action' => 'sesemailverified', 'verification_id' => $verification_id), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Unmark Email Verified'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemailverification', 'controller' => 'manage', 'action' => 'sesemailverified', 'verification_id' => $verification_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Mark Email Verified')))) ) ?>
            </td>
            <td class='admin_table_centered'>
              <?php echo ( $item->approved ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemailverification', 'controller' => 'manage', 'action' => 'approved', 'user_id' => $item->user_id), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disapproved'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemailverification', 'controller' => 'manage', 'action' => 'approved', 'user_id' => $item->user_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Approved')))) ) ?>
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
    <?php echo "There are no members upload document yet.";?>
  </span>
</div>
<?php endif;?>
