<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Edeletedmember/views/scripts/dismiss_message.tpl';?>

<p>
  <?php echo $this->translate("This page displays all the members who have deleted their accounts from your website. If you need to search for a specific member, enter your search criteria in the fields below.") ?>
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
        <th style='width: 1%;'><a href="javascript:void(0);" onclick="javascript:changeOrder('member_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
        <th style='width: 1%;'><a href="javascript:void(0);" onclick="javascript:changeOrder('email', 'ASC');"><?php echo $this->translate("Email") ?></a></th>
        <th><a href="javascript:void(0);" onclick="javascript:changeOrder('displayname', 'ASC');"><?php echo $this->translate("Display Name") ?></a></th>
        <th><a href="javascript:void(0);" onclick="javascript:changeOrder('username', 'ASC');"><?php echo $this->translate("Username") ?></a></th>
        <th>Creation Date</th>
        <th>Deletion Date</th>
        <!--<th style='width: 1%;' class='admin_table_options'><?php //echo $this->translate("Options") ?></th>-->
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ): ?>
          <tr>
            <td><?php echo $item->member_id ?></td>
            <td class='admin_table_email'><?php echo $item->email ?></td>
            <td class='admin_table_bold'>
              <?php echo $item->displayname; ?>
            </td>
            <td class='admin_table_user'><?php echo $item->username; ?></td>
            <td><?php echo $item->creation_date; ?></td>
            <td><?php echo $item->deletion_date; ?></td>
            
<!--            <td class='admin_table_options'>
              <a class='smoothbox' href='<?php //echo $this->url(array('action' => 'stats', 'id' => $item->member_id));?>'><?php //echo $this->translate("stats") ?></a>
            </td>-->
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
    <?php echo "There are no members in your search criteria.";?>
  </span>
</div>
<?php endif;?>
