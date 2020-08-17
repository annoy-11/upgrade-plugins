<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-transaction.tpl 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Package Transactions") ?></h3>
<p><?php echo $this->translate('This page lists all the payment transactions of the packages that have made on your site. You can use this page to monitor these Package Transactions. Entering criteria into the filter fields will help you find specific transaction. Leaving the filter fields blank will show all the transactions on your social network.'); ?></p>
<br />
<?php if( !empty($this->error) ): ?>
  <ul class="form-errors">
    <li>
      <?php echo $this->error ?>
    </li>
  </ul>
  <br />
<?php /*return; */ endif; ?>
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<div class='sesbasic_search_reasult'>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s transaction found", "%s transactions found", $count), $count) ?>  
</div>
<br />
<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
   	<table class='admin_table'>
    <thead>
      <tr>
        <th style='width: 1%;' >
          <a href="javascript:void(0);">
            <?php echo $this->translate("ID") ?>
          </a>
        </th>
        <th >
          <a href="javascript:void(0);">
            <?php echo $this->translate("Page ID") ?>
          </a>
        </th>
        <th >
          <a href="javascript:void(0);">
            <?php echo $this->translate("Page Title") ?>
          </a>
        </th>
        <th >
          <a href="javascript:void(0);">
            <?php echo $this->translate("Page Owner") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("Gateway") ?>
          </a>
        </th>
        
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("Status") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("Amount") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("Date") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_options'>
          <?php echo $this->translate("Options") ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $this->paginator as $item ):
        $user = Engine_Api::_()->getItem('user',$item->classroom_id);
        $classroom = Engine_Api::_()->getItem('classroom',$item->classroom_id);
        $package = Engine_Api::_()->getItem('sespagepackage_package',$item->package_id);
        ?>
        <tr>
          <td><?php echo $item->transaction_id ?></td>
           <td><?php echo $item->classroom_id ?></td>
           <td>
            <?php if(isset($classroom)):?>
             <a href="<?php echo $classroom->getHref(); ?>"  target='_blank' title="<?php echo  ucfirst($classroom->getTitle()) ?>">
                         <?php echo $this->translate(Engine_Api::_()->sesbasic()->textTruncation($classroom->getTitle(),25)) ?></a>
            <?php endif;?>
           </td>
           <td class='admin_table_bold'>
            <?php echo $user->__toString(); ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $item->gateway_type; ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $this->translate(ucfirst($item->state)) ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $package->getPackageDescription(); ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $this->locale()->toDateTime($item->creation_date) ?>
          </td>
          <td class='admin_table_options'>
            <a class="smoothbox" href='<?php echo $this->url(array('action' => 'detail', 'transaction_id' => $item->transaction_id, 'classroom_id' => $item->classroom_id));?>'>
              <?php echo $this->translate("details") ?>
            </a>
            <?php if($item->gateway_type == 'Bank Transfer'):?>
              |
              <a class="" href='<?php echo $this->url(array('action' => 'show-receipt', 'transaction_id' => $item->transaction_id));?>'>
                <?php echo 'View Receipt';?>
              </a>
              <?php if(Engine_Api::_()->getItem('coursespackage_orderspackage', $item->orderspackage_id)->state == 'pending'):?>
                |
                <a class="" href='<?php echo $this->url(array('action' => 'approve', 'transaction_id' => $item->transaction_id));?>'>
                  <?php echo 'Make Approve';?>
                </a>
              <?php endif;?>
            <?php endif;?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
     <?php else:?>
    <div class="tip">
      <span>
        <?php echo "No Transaction found yet.";?>
      </span>
    </div>
<?php endif; ?>
<div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'query' => $this->filterValues,
      'pageAsQuery' => true,
    )); ?>
  </div>
<script type="text/javascript"> 
  
  var SortablesInstance;

  window.addEvent('load', function() {
    SortablesInstance = new Sortables('menu_list', {
      clone: true,
      constrain: false,
      handle: '.item_label',
      onComplete: function(e) {
        reorder(e);
      }
    });
  });

 var reorder = function(e) {
     var menuitems = e.parentNode.childNodes;
     var ordering = {};
     var i = 1;
     for (var menuitem in menuitems)
     {
       var child_id = menuitems[menuitem].id;

       if ((child_id != undefined))
       {
         ordering[child_id] = i;
         i++;
       }
     }
 
    ordering['format'] = 'json';

    //Send request
    var url = '<?php echo $this->url(array("action" => "order")) ?>';
    var request = new Request.JSON({
      'url' : url,
      'method' : 'POST',
      'data' : ordering,
      onSuccess : function(responseJSON) {
      }
    });
    request.send();
  }
</script>
