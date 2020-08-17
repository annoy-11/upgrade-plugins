<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php  if(!$this->is_ajax): ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
<?php endif;?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonnumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonnumber = $this->identity; ?>
<?php endif;?>
<ul class="courses_listing sesbasic_clearfix clear" id="widget_courses_<?php echo $randonnumber; ?>">
  <div class="sesbasic_loading_cont_overlay" id="courses_widget_overlay_<?php echo $randonnumber; ?>"></div>
  <?php foreach($this->paginator as $course):?>
  <?php $owner = $course->getOwner();  ?>
		<li class="courses_grid_item" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
    <article class="sesbasic_clearfix">
      <div class="_thumb courses_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height?>;">
        <a href="<?php echo $course->getHref(); ?>" class="courses_thumb_img">
          <?php if(isset($this->coursePhotoActive)):?>
            <span style="background-image:url('<?php echo $course->getPhotoUrl('thumb.profile'); ?>');"></span>
          <?php endif;?> 
        </a>
        <div class="courses_labels">
          <?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataLabel.tpl';?>
        </div>
        <div class="_btns sesbasic_animation">
         <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataSharing.tpl';?>
         <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataButtons.tpl';?>
        </div>
      </div>
      <div class="_cont">
        <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_coursePrice.tpl';?>
        <?php if(isset($this->titleActive)):?>
          <div class="_title">
            <a href="<?php echo $course->getHref(); ?>">
              <?php if(strlen($course->getTitle()) > $this->title_truncation_limit):?>
                  <?php $title = mb_substr($course->getTitle(),0,$this->title_truncation_limit).'...';?>
                  <?php echo $this->htmlLink($course->getHref(),$title,array('title'=>$course->getTitle()));?>
              <?php else: ?>
                  <?php echo $this->htmlLink($course->getHref(),$course->getTitle(),array('title'=>$course->getTitle())  ) ?>
              <?php endif;?>   
            </a>
          </div>    
        <?php endif;?>
        <?php if((isset($category) && isset($this->categoryActive)) || isset($this->byActive)): ?>
            <?php if($course->category_id != '' && intval($course->category_id) && !is_null($course->category_id)) {  
                    $category_id = $course->category_id; 
                  } else {
                    $category_id = 0;
                 }
            ?>
            <?php $category = Engine_Api::_()->getItem('courses_category', $category_id);?>
          <div class="owner sesbasic_text_light">
             <?php if(isset($category) && isset($this->categoryActive)): ?> 
              <?php echo $this->translate('Posted in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a>
            <?php endif;?>
            <?php if(isset($this->byActive)): ?> 
              <?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?>
             <?php endif;?>
          </div>
        <?php endif;?>
        <?php if(isset($this->ratingActive)):?>
          <div class="sesbasic_rating_star">
              <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/rating.tpl';?>
          </div>
        <?php endif;?>
        <div class="_stats">
           <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_data.tpl';?>
           <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataStatics.tpl';?>
        </div>
     </div>
    </article>
  </li>  
  <?php endforeach;?>
  <?php if(isset($this->widgetName)){ ?>
		<div class="sidebar_privew_next_btns">
			<div class="sidebar_previous_btn">
				<?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
					'id' => "widget_previous_".$randonnumber,
					'onclick' => "widget_previous_$randonnumber()",
					'class' => 'buttonlink previous_icon'
				)); ?>
			</div>
			<div class="sidebar_next_btns">
				<?php echo $this->htmlLink('javascript:void(0);', $this->translate('Next'), array(
					'id' => "widget_next_".$randonnumber,
					'onclick' => "widget_next_$randonnumber()",
					'class' => 'buttonlink_right next_icon'
				)); ?>
			</div>
		</div>
	<?php } ?>
</ul>
<?php if(isset($this->widgetName)){ ?>
  <script type="application/javascript">
		var anchor_<?php echo $randonnumber ?> = sesJqueryObject('#widget_courses_<?php echo $randonnumber; ?>').parent();
		function showHideBtn<?php echo $randonnumber ?> (){ 
			sesJqueryObject('#widget_previous_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>');
			sesJqueryObject('#widget_next_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' ) ?>');	
		}
		showHideBtn<?php echo $randonnumber ?> ();
		function widget_previous_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/courses/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
				data : {
					format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>', 
					page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() - 1) ?>
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send()
		};

		function widget_next_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/courses/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
				data : {
					format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>' , 
					page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send();
		};
	</script>
<?php } ?>
