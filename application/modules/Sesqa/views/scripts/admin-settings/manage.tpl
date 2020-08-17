<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate('Are you sure you want to delete the selected question?');?>");
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
<?php include APPLICATION_PATH .  '/application/modules/Sesqa/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings'>
    <?php //echo $this->form->render($this); ?>
  </div>
</div>
<h3><?php echo $this->translate("Manage Questions") ?></h3>
<p><?php echo $this->translate('This page list all the questions created on your website. You can use this page to monitor these Questions and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific question. Leaving the filter fields blank will show all the questions on your social network. <br /><br />
Below, you can also choose any number of Questions as Questions of the Day, Featured, Sponsored, Verified and Hot. You can also Approve and Disapprove Questions.') ?></p>

<br />
<?php
$settings = Engine_Api::_()->getApi('settings', 'core');?>	
<div class='admin_search sesqa_search_form'>
  <?php echo $this->form->render($this) ?>
</div>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesqa_search_result">
    <?php echo $this->translate(array('%s album found.', '%s albums found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
<form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate('Title') ?></th>
        <th><?php echo $this->translate('Owner') ?></th>
        <th align="center"><?php echo $this->translate('Approved') ?></th>
        <th align="center"><?php echo $this->translate('Featured') ?></th>
        <th align="center"><?php echo $this->translate('Sponsored') ?></th>
        <th align="center"><?php echo $this->translate('Hot') ?></th>
        <th align="center"><?php echo $this->translate('Verified') ?></th>
        <th align="center"><?php echo $this->translate("Of the Day") ?></th>
        <th><?php echo $this->translate('Options') ?></th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($this->paginator as $item): ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->question_id;?>' value="<?php echo $item->question_id ?>"/></td>
            <td><?php echo $item->getIdentity() ?></td>
            <td><?php echo $this->htmlLink($item->getHref(), $item->getTitle()); ?></td> 
            <td><?php echo $this->htmlLink($item->getHref(), $item->getOwner()); ?></td>
            <td class="admin_table_centered"><?php echo $item->approved == 1 ?   $this->htmlLink(array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'approved', 'id' => $item->question_id,'status' =>0,'category' =>'approved'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Approved')))) : $this->htmlLink(array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'approved', 'id' => $item->question_id,'status' =>1,'category' =>'approved'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Approved')))) ; ?>
            </td>
            <td class="admin_table_centered"><?php echo $item->featured == 1 ?   $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'feature-sponsored', 'id' => $item->question_id,'status' =>0,'category' =>'featured'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) : $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'feature-sponsored', 'id' => $item->question_id,'status' =>1,'category' =>'featured'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ; ?></td>
            <td class="admin_table_centered"><?php echo $item->sponsored == 1 ? $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'feature-sponsored', 'id' => $item->question_id,'status' =>0,'category' =>'sponsored'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) : $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'feature-sponsored', 'id' => $item->question_id,'status' =>1,'category' =>'sponsored'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored'))))  ; ?></td>
            
            <td class="admin_table_centered"><?php echo $item->hot == 1 ? $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'hot', 'id' => $item->question_id,'status' =>0,'category' =>'hot'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) : $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'hot', 'id' => $item->question_id,'status' =>1,'category' =>'hot'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored'))))  ; ?></td>    
            
            <td class="admin_table_centered"><?php echo $item->verified == 1 ? $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'verified', 'id' => $item->question_id,'status' =>0,'category' =>'verified'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) : $this->htmlLink(
                array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'verified', 'id' => $item->question_id,'status' =>1,'category' =>'verified'),$this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored'))))  ; ?></td>
            <td class="admin_table_centered">
            <?php if(strtotime($item->endtime) < strtotime(date('Y-m-d')) && $item->offtheday == 1){ 
            			Engine_Api::_()->getDbtable('questions', 'sesqa')->update(array(
                      'offtheday' => 0,
                      'starttime' =>'',
                      'endtime' =>'',
                    ), array(
                      "question_id = ?" => $item->question_id,
                    ));
                    $itemofftheday = 0;
             }else
             	$itemofftheday = $item->offtheday; ?>
            <?php if($itemofftheday == 1):?>  
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'oftheday', 'id' => $item->question_id, 'type' => 'album', 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit  Album of the Day'))), array('class' => 'smoothbox')); ?>
            <?php else: ?>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'oftheday', 'id' => $item->question_id, 'type' => 'album', 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make  Album of the Day'))), array('class' => 'smoothbox')) ?>
            <?php endif; ?>
          </td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'view', 'id' => $item->question_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
              |
              <a href="<?php echo $item->getHref(); ?>" target="_blank">
                <?php echo $this->translate('View') ?>
              </a>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesqa', 'controller' => 'admin-settings', 'action' => 'delete', 'id' => $item->question_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
  <br/>
  <div class='buttons'>
    <button type='submit'>
      <?php echo $this->translate('Delete Selected') ?>
    </button>
  </div>
</form>
<br />
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no questions posted by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>
<script>
 function showSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesqa/index/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id')) {
            $('subcat_id').parentNode.style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id')) {
            $('subcat_id').parentNode.style.display = "none";
            $('subcat_id').innerHTML = '';
          }
					 if ($('subsubcat_id')) {
            $('subsubcat_id').parentNode.style.display = "none";
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
    var url = en4.core.baseUrl + 'sesqa/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id')) {
            $('subsubcat_id').parentNode.style.display = "inline-block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
					// get category id value 
        } else {
          if ($('subsubcat_id')) {
            $('subsubcat_id').parentNode.style.display = "none";
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
	  $('subcat_id').parentNode.style.display = "none";
	 <?php } ?>
	 <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
      showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>');
	 <?php }else{?>
	 		 $('subsubcat_id').parentNode.style.display = "none";
	 <?php } ?>
</script>
