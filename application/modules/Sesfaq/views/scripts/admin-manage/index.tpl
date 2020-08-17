<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected FAQs?');?>");
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

    // Send request
    var url = '<?php echo $this->url(array('action' => 'order-manage-faq')) ?>';
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

<?php include APPLICATION_PATH .  '/application/modules/Sesfaq/views/scripts/dismiss_message.tpl';?>

<h3><?php echo $this->translate("Add & Manage FAQs") ?></h3>
<p><?php echo $this->translate('This page lists all the FAQs you have created. You can use this page to monitor these faqs and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific faq. Leaving the filter fields blank will show all the faqs on your social network.<br />Below, you can also enable or disable any FAQ, view their rating and helpful statistics. Use the "Add New FAQ" link to create and add new FAQs. <br />To reorder the FAQs, click on their names and drag them up or down.'); ?></p>
<br />

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfaq', 'controller' => 'manage', 'action' => 'create'), $this->translate('Add New FAQ'), array('class' => 'buttonlink sesfaq_icon_add')); ?>

<br /><br />

<div class='admin_search sesfaq_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesfaq_search_reasult">
    <?php echo $this->translate(array('%s faq found.', '%s faqs found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="admin_table_form">
      <table class='admin_table sesfaq_admin_manage_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('faq_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><?php echo $this->translate("Helpful") ?></th>
            <th><?php echo $this->translate("Ratings") ?></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('status', 'ASC');" title="Status"><?php echo $this->translate("Status") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody id='menu_list'>
          <?php foreach ($this->paginator as $item): ?>
          <?php
            $helpfulCountforYes = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->helpfulCount($item->faq_id, 1);
            $helpfulCountforNo = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->helpfulCount($item->faq_id, 2);
            $totalHelpful = $helpfulCountforYes + $helpfulCountforNo;
            $percentageHelpful = ($helpfulCountforYes / ($totalHelpful))*100;
            if($percentageHelpful > 0) {
              $final_value = round($percentageHelpful);
            } else {
              $final_value = 0;
            }
          ?>
          <tr class="item_label" id="managesearch_<?php echo $item->faq_id ?>">
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->faq_id;?>' value="<?php echo $item->faq_id; ?>" /></td>
            <td><?php echo $item->faq_id ?></td>
            <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesfaq()->textTruncation($item->getTitle(),36)), array('title' => $item->getTitle(), 'target' => '_blank')) ?></td>
            <td><?php echo !empty($final_value) ? $final_value.'%' : '---'; ?></td>
            <td>
              <?php if($item->rating): ?>
              <div class="sesfaq_rating_star">
                <?php if( $item->rating > 0 ): ?>
                <?php for( $x=1; $x<= $item->rating; $x++ ): ?>
                	<span class="sesfaq_rating_star_small fa fa-star"></span>
                <?php endfor; ?>
                <?php if((round($item->rating) - $item->rating) > 0): ?>
                	<span class="sesfaq_rating_star_small fa fa-star-half-o"></span>
                <?php endif; ?>
                <?php endif; ?>
              </div>
              <?php else: ?>
              	<div class="sesfaq_rating_star">
                	<?php for( $x=1; $x<= 5; $x++ ): ?>
                  	<span class="sesfaq_rating_star_small fa fa-star-o star-disabled"></span>
                	<?php endfor; ?>
                </div>
              <?php endif; ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->status == 1):?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfaq', 'controller' => 'admin-manage', 'action' => 'status', 'id' => $item->faq_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesfaq/externals/images/check.png', '', array('title'=> $this->translate('Disable')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfaq', 'controller' => 'admin-manage', 'action' => 'status', 'id' => $item->faq_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesfaq/externals/images/error.png', '', array('title'=> $this->translate('Enable')))) ?>
              <?php endif; ?>
            </td>
            <td><?php echo $item->creation_date ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfaq', 'controller' => 'admin-manage', 'action' => 'edit', 'faq_id' => $item->faq_id), $this->translate("Edit"), array('class' => '')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfaq', 'controller' => 'admin-manage', 'action' => 'view', 'id' => $item->faq_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink($item->getHref(), $this->translate("View"), array('target' => '_blank')); ?>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfaq', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->faq_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <br />
    <div class='buttons'>
      <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
  </form>
  <br/>
  <div>
    <?php echo $this->paginationControl($this->paginator,null,null,$this->urlParams); ?>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no FAQs created by you yet.") ?>
    </span>
  </div>
<?php endif; ?>
<script type="text/javascript">
  function showSubCategory(cat_id) {
    var url = en4.core.baseUrl + 'sesfaq/index/subcategory/category_id/' + cat_id;
    en4.core.request.send(new Request.HTML({
      url: url,
      data: {
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "none";
            $('subcat_id').innerHTML = '';
          }
        }
      }
    }));
  }
function showSubSubCategory(cat_id) {

    var url = en4.core.baseUrl + 'sesfaq/index/subsubcategory/subcategory_id/' + cat_id;

    en4.core.request.send(new Request.HTML({
      url: url,
      data: {
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "inline-block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
        } else {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }));
  }
  window.addEvent('domready', function() {
    if ($('category_id') && $('category_id').value == 0)
     $('subcat_id-wrapper').style.display = "none";   
		if ($('subcat_id') && $('subcat_id').value == 0)
     $('subsubcat_id-wrapper').style.display = "none"; 
  });
</script>
<style type="text/css">
	div.sesfaq_search_form form{
		padding:10px;
	}
	div.sesfaq_search_form form > div {
		display:inline-block;
		float:none;
		margin:5px 10px 5px 0;
	}
	div.sesfaq_search_form form > div label{
		font-weight:normal;
	}
	div.sesfaq_search_form form > div input[type="text"],
	div.sesfaq_search_form form > div select{
		min-width:100px;
		padding:5px;
	}
</style>