<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<script type="discussion/javascript">

function multiDelete()
{
  return confirm("<?php echo $this->translate('Are you sure you want to delete the selected discussion entries?');?>");
}

function selectAll()
{
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

<?php include APPLICATION_PATH .  '/application/modules/Sesdiscussion/views/scripts/dismiss_message.tpl';?>

<h3>Manage Discussions</h3>
<p>
  <?php echo $this->translate("This page lists all of the discussions your users have created. You can use this page to monitor these discussions and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific discussion. Leaving the filter fields blank will show all the discussions on your social network. ") ?>
</p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<br />

<?php if( count($this->paginator) ): ?>
<div class="sesbasic_search_reasult">
  <?php echo $this->translate(array('%s discussion found.', '%s discussions found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
</div>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
      <th class='admin_table_short'>ID</th>
      <th><?php echo $this->translate("Title") ?></th>
      <th><?php echo $this->translate("Owner") ?></th>
      <th align="center"><?php echo $this->translate("Of the Day") ?></th>
      <th><?php echo $this->translate("Creation Date") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr>
        <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
        <td><?php echo $item->getIdentity() ?></td>
        <td><a href="<?php echo $item->getHref(); ?>"><?php echo $this->string()->truncate($this->string()->stripTags($item->getTitle()), 40) ?></a></td>
        <td><a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $item->getOwner()->getTitle() ?></a></td>
        <td class="admin_table_centered">
          <?php if(strtotime($item->endtime) < strtotime(date('Y-m-d')) && $item->offtheday == 1){ 
          Engine_Api::_()->getDbtable('discussions', 'sesdiscussion')->update(array(
          'offtheday' => 0,
          'starttime' =>'',
          'endtime' =>'',
          ), array(
          "discussion_id = ?" => $item->discussion_id,
          ));
          $itemofftheday = 0;
          } else
          $itemofftheday = $item->offtheday; ?>
          <?php if($itemofftheday == 1):?>  
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesdiscussion', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->discussion_id, 'type' => 'discussion', 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Video of the Day'))), array('class' => 'smoothbox')); ?>
          <?php else: ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesdiscussion', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->discussion_id, 'type' => 'discussion', 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Video of the Day'))), array('class' => 'smoothbox')) ?>
          <?php endif; ?>
        </td>
        
        
        <td><?php echo $this->locale()->toDateTime($item->creation_date) ?></td>
        <td>
          <?php echo $this->htmlLink($item->getHref(), $this->translate('view')) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesdiscussion', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->discussion_id), $this->translate("delete"), array('class' => 'smoothbox')); ?>
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
      <?php echo $this->translate("There are no discussion entries posted by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>


<script>
 function showSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesdiscussion/category/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id')) {
            $('subcat_id-label').parentNode.style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id')) {
            $('subcat_id-label').parentNode.style.display = "none";
            $('subcat_id').innerHTML = '';
          }
					 if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }).send(); 
  }
	function showSubSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesdiscussion/category/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "inline-block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
					// get category id value 
        } else {
          if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    })).send();  
 }
	var sesdevelopment = 1;
	<?php if(isset($this->category_id) && $this->category_id != 0){ ?>
			<?php if(isset($this->subcat_id) && $this->subcat_id != 0){$catId = $this->subcat_id;}else $catId = ''; ?>
      showSubCategory('<?php echo $this->category_id ?>','<?php echo $catId; ?>');
   <?php  }else{?>
	  $('subcat_id-label').parentNode.style.display = "none";
	 <?php } ?>
	 <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
      showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>');
	 <?php }else{?>
	 		 $('subsubcat_id-label').parentNode.style.display = "none";
	 <?php } ?>
</script>