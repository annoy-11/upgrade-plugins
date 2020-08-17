<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script>

  function showSubCategory(cat_id,selected) {

    new Request.HTML({
      url: en4.core.baseUrl + 'seswishe/category/subcategory/category_id/' + cat_id,
      data: {
        'selected':selected
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
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }).send();
  }
  
  function showSubSubCategory(cat_id,selected) {
    if(cat_id == 0){
      if ($('subsubcat_id-wrapper')) {
        $('subsubcat_id-wrapper').style.display = "none";
        $('subsubcat_id').innerHTML = '';
      }
      return false;
    }

    (new Request.HTML({
      url: en4.core.baseUrl + 'seswishe/category/subsubcategory/subcategory_id/' + cat_id,
      data: {
      'selected':selected
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
    })).send();  
  }

  en4.core.runonce.add(function() {
    if($('category_id')) {
      <?php if(isset($_GET['category_id']) && $_GET['category_id'] != 0) { ?>
        <?php if(isset($_GET['subcat_id'])){$catId = $_GET['subcat_id'];}else $catId = ''; ?>
          showSubCategory('<?php echo $_GET['category_id']; ?>','<?php echo $catId; ?>');
        <?php if(isset($_GET['subsubcat_id'])){ ?>
          <?php if(isset($_GET['subsubcat_id'])){$subsubcat_id = $_GET['subsubcat_id'];}else $subsubcat_id = ''; ?>
            showSubSubCategory("<?php echo $_GET['subcat_id']; ?>","<?php echo $_GET['subsubcat_id']; ?>");
          <?php } else { ?>
            $('subsubcat_id-wrapper').style.display = "none";
          <?php } ?>
      <?php  } else { ?>
        $('subcat_id-wrapper').style.display = "none";
        $('subsubcat_id-wrapper').style.display = "none";
      <?php } ?>
    }
  });
</script>
<?php $randonNumber = 8000; ?>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $actionName = $request->getActionName();?>
<?php //if($actionName == 'browse') { ?>
  <script type="application/javascript">
    en4.core.runonce.add(function() {
      sesJqueryObject('#filter_form').submit(function(e) {
          e.preventDefault();
          sesJqueryObject('#loadingimgseswishe-wrapper').show();
          sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').html('');
          searchParams = sesJqueryObject(this).serialize();
          page = 1;
          loadMoreWISHE();
        return true;
      });
    });
  </script>
<?php //} ?>
<?php if( $this->form ): ?>
	<div class="seswishe_browse_search sesbasic_bxs sesbasic_clearfix <?php if($this->viewType == 'horizontal') { ?> seswishe_browse_search_horrizontal<?php } ?>">
  	<?php echo $this->form->render($this) ?>
  </div>
<?php endif ?>
<script>
en4.core.runonce.add(function() {
  sesJqueryObject('#loadingimgseswishe-wrapper').hide();
});
</script>
