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
<script>

  function showSubCategory(cat_id,selected) {

    new Request.HTML({
      url: en4.core.baseUrl + 'sesdiscussion/category/subcategory/category_id/' + cat_id,
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
      url: en4.core.baseUrl + 'sesdiscussion/category/subsubcategory/subcategory_id/' + cat_id,
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
  
  window.addEvent('domready', function() {
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

<?php if( $this->form ): ?>
	<div class="sesdiscussion_browse_search sesbasic_bxs sesbasic_clearfix <?php if($this->viewType == 'horizontal') { ?> sesdiscussion_browse_search_horrizontal<?php } ?>">
  	<?php echo $this->form->render($this) ?>
  </div>
<?php endif ?>
