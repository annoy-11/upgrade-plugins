<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-reviews.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/style_dashboard.css'); ?>

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

<script type="text/javascript">

  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected reviews?');?>");
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
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
    <div class='admin_search estore_reviews_table'>
<?php } ?>
<div class='clear sesbasic-form'>
  <div>
    <div class="sesbasic-form-cont">
      <div class='settings estore_Reviews_form'>
				<h3><?php echo $this->translate("Manage Reviews"); ?></h3>
				<br/>
				<div class="admin_search estore_browse_search estore_browse_search_horizontal sesbasic_clearfix sesbasic_bxs">
				  <?php echo $this->reviewFormFilter->render($this) ?>
				</div>
				<div class="estore_dashboard_table sesbasic_bxs">
					<?php $counter = $this->paginator->getTotalItemCount(); ?> 
					<?php if( count($this->paginator) ): ?>
				  <div class="sesbasic_search_reasult" style="margin-bottom: 7px;">
				    <?php echo $this->translate(array('%s review found.', '%s reviews found.', $counter), $this->locale()->toNumber($counter)) ?>
				  </div>
				  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
				    <table class="admin_table">
				      <thead>
				        <tr>
				          <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
				          <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('review_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
				          <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Review Title") ?></a></th>
				          <th><?php echo $this->translate("Store Name") ?></th>
				          <th><a href="javascript:void(0);" onclick="javascript:changeOrder('owner_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>

				          <th><?php echo $this->translate("Options") ?></th>
				        </tr>
				      </thead>
				      <tbody>
				        <?php foreach ($this->paginator as $item): ?>
				        <tr>
				          <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->review_id;?>' value="<?php echo $item->review_id; ?>" /></td>
				          <td><?php echo $item->review_id ?></td>
				          <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),16)), array('title' => $item->getTitle(), 'target' => '_blank')) ?></td>
				          
				          <td>
				            <?php $contentItem = Engine_Api::_()->getItem('stores', $item->store_id); ?>
				            <?php echo $this->htmlLink($contentItem->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($contentItem->getTitle(),16)), array('title' => $contentItem->getTitle(), 'target' => '_blank')) ?></td>
				          
				          <td><?php echo $this->htmlLink($item->getOwner()->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getOwner()->getTitle(),16)), array('title' => $this->translate($item->getOwner()->getTitle()), 'target' => '_blank')) ?></td>
				          <td><span>
				            <?php echo $this->htmlLink($item->getHref(), $this->translate("View"), array('class' => '')); ?></span>
				            |
				            <?php //echo $this->htmlLink(array('route' => 'default', 'module' => 'estore', 'controller' => 'manage', 'action' => 'delete-review', 'id' => $item->review_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
				            <a href="javascript:void(0);" onclick="deleteReview('<?php echo $item->review_id; ?>',this)"><?php echo $this->translate("Delete"); ?></a>
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
				</div>
				  <br/>
				  <div>
				    <?php echo $this->paginationControl($this->paginator); ?>
				  </div>
				<?php else:?>
				  <div class="tip">
				    <span>
				      <?php echo $this->translate("There are no reviews created by your members yet.") ?>
				    </span>
				  </div>
				<?php endif; ?>

      </div>
    </div>
  </div>
</div>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
</div>
<?php } ?>
<script>
sesJqueryObject('#loadingimgestore-wrapper').hide();
 sesJqueryObject(document).on('submit','#filter_form',function(event){
	event.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#loadingimgestore-wrapper').show();
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'estore/manage/my-reviews/',
			data : {
				format : 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#loadingimgestore-wrapper').hide();
				sesJqueryObject('.estore_reviews_table').html(response);
			}
	}).send();
});

function deleteReview(review_id ,obj){
var confirmDelete = confirm('Are you sure you want to delete the selected Review?');
if(confirmDelete){
 if(confirm(confirmDelete)){
sesJqueryObject('#loadingimgestore-wrapper').show();
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'estore/manage/my-reviews/',
			data : {
				format : 'html',
				review_id :review_id, 
				is_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#loadingimgestore-wrapper').hide();
				sesJqueryObject('.estore_reviews_table').html(response);
			}
	}).send();
	}
}
}
</script>
<?php if($this->is_ajax || $this->is_search_ajax) die(); ?>




