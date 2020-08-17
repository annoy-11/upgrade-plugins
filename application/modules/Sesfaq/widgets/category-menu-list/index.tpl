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
<div class="sesfaq_category_menu_list sesfaq_clearfix sesfaq_bxs">
  <ul class="category_menu">
    <?php foreach($this->resultcategories as $resultcategorie): ?>
      <li class="active toggled_menu_parant">
      <img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" />
      <?php $subcategories = Engine_Api::_()->getDbTable('categories', 'sesfaq')->getModuleSubcategory(array('category_id' => $resultcategorie->category_id, 'column_name' => '*')); ?>
      <a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($resultcategorie->category_id) ; ?>" class="sesfaq_linkinherit"><?php echo $this->translate($resultcategorie->category_name); ?> <?php if(count($subcategories) > 0): ?><i class="fa fa-plus dropdown_icon sesfaq_sidebarcategory"></i><?php endif; ?></a>
      <?php if(count($subcategories) > 0): ?>
        <ul class="" style="display:none;">
          <?php foreach($subcategories as $subcategory): ?>
            <li><a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($subcategory->subcat_id) . '&subcat_id='.urlencode($subcategory->category_id) ?>"><?php echo $this->translate($subcategory->category_name); ?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<script type="text/javascript">

	sesJqueryObject(document).on('click','.sesfaq_sidebarcategory',function(e){
	  if(sesJqueryObject(this).parent().parent().find('ul').children().length == 0)
	  	return true;
	  e.preventDefault();
	  
	  sesJqueryObject('.sesfaq_sidebarcategory.fa-minus').removeClass('fa-minus').addClass('fa-plus');
	  
	  console.log(sesJqueryObject('.sesfaq_sidebarcategory.fa-minus'));
	  
	  if(sesJqueryObject(this).parent().hasClass('open_toggled_menu')) {
      sesJqueryObject('.open_toggled_menu').parent().find('ul').slideToggle('slow');
      sesJqueryObject(this).parent().removeClass('open_toggled_menu');
      sesJqueryObject(this).addClass('fa-plus');
	  } else {
      sesJqueryObject('.open_toggled_menu').parent().find('ul').slideToggle('slow');
      sesJqueryObject(this).parent().parent().find('ul').slideToggle('slow');
      sesJqueryObject('.open_toggled_menu').removeClass('open_toggled_menu');
      sesJqueryObject(this).parent().addClass('open_toggled_menu');
      sesJqueryObject(this).removeClass('fa-plus').addClass('fa-minus');
	  }
	  return false;
  });

</script>