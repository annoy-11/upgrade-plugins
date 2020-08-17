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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesfaq/externals/styles/styles.css'); ?>

<?php if( $this->form ): ?>
  <div class="<?php echo $this->viewType=='horizontal' ? 'sesfaq_browse_search_horizontal' : 'sesfaq_browse_search_vertical'; ?> sesfaq_bxs">
    <?php echo $this->form->render($this) ?>
  </div>
<?php endif; ?>

<script type="text/javascript">
var title_name = document.getElementById("title_name");
title_name.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        this.form.submit();
    }
});
  
if($('category_id')) {
  window.addEvent('domready', function() {
  
    if ($('category_id').value == 0) {
      $('subcat_id-wrapper').style.display = "none";
      $('subsubcat_id-wrapper').style.display = "none";
    }
    
    var cat_id = $('category_id').value;
    if ($('subcat_id')) 
      var subcat = $('subcat_id').value;
    
    if(subcat == '')
      $('subcat_id-wrapper').style.display = "none";
    
    if (subcat == 0)
      $('subsubcat_id-wrapper').style.display = "none";
    
    if ($('subsubcat_id'))
      var subsubcat = $('subsubcat_id').value;

    if (cat_id)
      ses_subcategory(cat_id);
  });
}

//Function for get sub category
function ses_subcategory(category_id, module) {
  temp = 1;
  if (category_id == 0) {
    if ($('subcat_id-wrapper')) {
      $('subcat_id-wrapper').style.display = "none";
      $('subcat_id').innerHTML = '';
    }

    if ($('subsubcat_id-wrapper')) {
      $('subsubcat_id-wrapper').style.display = "none";
      $('subsubcat_id').innerHTML = '';
    }
    return false;
  }

  var request = new Request.HTML({
    url: en4.core.baseUrl + 'sesfaq/index/subcategory/category_id/' + category_id,
    data: {
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

      if ($('subcat_id') && responseHTML) {
        if ($('subcat_id-wrapper')) {
          $('subcat_id-wrapper').style.display = "block";
        }

        $('subcat_id').innerHTML = responseHTML;
        <?php if(isset($_GET['subcat_id']) && $_GET['subcat_id']): ?>
        $('subcat_id').value = '<?php echo $_GET["subcat_id"] ?>';
        sessubsubcat_category('<?php echo $_GET["subcat_id"] ?>');
        <?php endif; ?>
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

//Function for get sub sub category
function sessubsubcat_category(category_id, module) {

  if (category_id == 0) {
    if ($('subsubcat_id-wrapper')) {
      $('subsubcat_id-wrapper').style.display = "none";
      $('subsubcat_id').innerHTML = '';
    }
    return false;
  }

  var request = new Request.HTML({
    url: en4.core.baseUrl + 'sesfaq/index/subsubcategory/category_id/' + category_id,
    data: {
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if ($('subsubcat_id') && responseHTML) {
        if ($('subsubcat_id-wrapper'))
          $('subsubcat_id-wrapper').style.display = "block";
        $('subsubcat_id').innerHTML = responseHTML;
        <?php if(isset($_GET['subsubcat_id']) && $_GET['subsubcat_id']): ?>
          $('subsubcat_id').value = '<?php echo $_GET["subsubcat_id"] ?>';
        <?php endif; ?>
      } else {
        if ($('subsubcat_id-wrapper')) {
          $('subsubcat_id-wrapper').style.display = "none";
          $('subsubcat_id').innerHTML = '';
        }
      }
    }
  }).send();

} 
</script>