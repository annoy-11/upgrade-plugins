<?php



/**

 * SocialEngineSolutions

 *

 * @category   Application_Sesgroupveroth

 * @package    Sesgroupveroth

 * @copyright  Copyright 2018-2019 SocialEngineSolutions

 * @license    http://www.socialenginesolutions.com/license/

 * @version    $Id: index.tpl  2018-11-02 00:00:00 SocialEngineSolutions $

 * @author     SocialEngineSolutions

 */

 

 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>

    <?php if( count($this->subNavigation) ): ?>

      <div class='sesbasic-admin-sub-tabs'>

        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>

      </div>

    <?php endif; ?>

<h3>Manage Verified Groups</h3>

<p>

  <?php echo $this->translate('This page lists all the groups verified by the members on your website. You can use this page to monitor these verified Groups and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific group. Leaving the filter fields blank will show all the groups on your social network.'); ?>

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

<?php if(count($this->paginator) > 0):?>

<div class='sesbasic_search_result'>

  <?php $count = $this->paginator->getTotalItemCount() ?>

  <?php echo $this->translate(array("%s group found.", "%s groups found.", $count),

      $this->locale()->toNumber($count)) ?>

</div>

<div>

  <?php echo $this->paginationControl($this->paginator, null, null, array(

    'groupAsQuery' => true,

    'query' => $this->formValues,

    //'params' => $this->formValues,

  )); ?>

</div>

<div class="admin_table_form sesgroupveroth_manage_members">

<form>

  <table class='admin_table' style="width:100%;">

    <thead>

      <tr>

        <th><?php echo $this->translate("ID") ?></th>

        <th><?php echo $this->translate("Verified Group") ?></th>

        <th class="admin_table_centered"><?php echo $this->translate("Total Verifications") ?></th>

        <th class="admin_table_centered" style="width:25%;"><?php echo $this->translate("Status") ?></th>

        <th style='width:25%;' class='admin_table_options'><?php echo $this->translate("Options") ?></th>

      </tr>

    </thead>

    <tbody>

      <?php if( count($this->paginator) ): ?>

        <?php foreach( $this->paginator as $item ):



          $poster = $this->item('user', $item->poster_id);

          $resource = $this->item('sesgroup_group', $item->resource_id);

          ?>

          <tr>

            <td><?php echo $item->verification_id ?></td>

            <td class='admin_table_bold _member'>

            	<?php echo $this->htmlLink($resource->getHref(), $this->itemPhoto($resource, 'thumb.icon')); ?>

              <span><?php echo $this->htmlLink($resource->getHref(), $this->string()->truncate($resource->getTitle(), 16), array('target' => '_blank'))?></span>

            </td>

            <td class="admin_table_centered">

              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'view', 'resource_id' => $item->resource_id));?>'><?php echo $item->totalverificationcount; ?></a>

            </td>

            <td class="admin_table_centered">

              <?php echo ( $item->admin_enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesgroupveroth', 'controller' => 'manage', 'action' => 'enabled', 'resource_id' => $item->resource_id, 'admin_enabled' => $item->admin_enabled), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesgroupveroth', 'controller' => 'manage', 'action' => 'enabled', 'resource_id' => $item->resource_id, 'admin_enabled' => $item->admin_enabled), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>

            </td>

            <td class='admin_table_options'>

              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'view', 'resource_id' => $item->resource_id));?>'><?php echo $this->translate("View Verifications") ?></a>

              |

              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'remove', 'resource_id' => $item->resource_id));?>'><?php echo $this->translate("Remove") ?></a>

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

    <?php echo "Currently, there are no verified groups on your website.";?>

  </span>

</div>

<?php endif;?>

