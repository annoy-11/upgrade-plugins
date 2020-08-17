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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>

<div class="courses_compare_view sesbasic_clearfix sesbasic_bxs">
  <div class="courses_compare_view_inner">
    <table class="courses_compare_table">
      <tbody>
        <tr id="total_courses_compared" data-courses="<?php echo count($this->courses); ?>">
          <td></td>
          <?php foreach($this->courses as $course): ?>
          <td class="courses_compare_id_<?php echo $course->getIdentity(); ?>">
            <div class="course_compare_info"> 
              <?php if(count($this->courses) > 2) { ?>
                <a  href="javascript:;" onclick ="removeCourseToCompare('<?php echo $course->getIdentity(); ?>','<?php echo $course->category_id; ?>')">
                  <?php echo $this->translate('Remove'); ?> <span class="compare_close remove"><?php echo $this->translate('x'); ?></span>
                </a>
              <?php } ?>
              <?php if(isset($this->coursePhotoActive)):?>
                <div class="_img"><img src="<?php echo $course->getPhotoUrl(); ?>" />
              <?php endif; ?>
                <div class="_btns sesbasic_animation">
                  <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataButtons.tpl';?>
                </div>
              </div>
              <?php if(isset($this->courseTitleActive)):?>
                <div class="_title"><?php echo $course->getTitle(); ?></div>
              <?php endif; ?>
              <div class="_counts"> 
                  <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataStatics.tpl';?>
              </div>
              <div class="_add_cart"> 
                <?php if(isset($this->addCartActive)):?>
                  <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_addToCart.tpl';?>
                <?php endif; ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.wishlist', 1) && Engine_Api::_()->courses()->allowAddWishlist() && isset($this->addWishlistActive)): ?>
                  <a href="javascript:;" data-rel="<?php echo $course->getIdentity(); ?>" class="courses_wishlist" data-rel="<?php echo $course->getIdentity(); ?>"   title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-bookmark-o"></i> <?php echo $this->translate('Add to wishlist'); ?></a>
                <?php endif; ?>
              </div>
            </div>
          </td>
        <?php  endforeach; ?>
        </tr>
        <?php $price = ''; $description = ''; $discount =''; $categoriesData=''; $creationDate=''; $lectureCount=''; $testCount =''; $Owner ='';?>
        <?php foreach($this->courses as $course): ?>
         <?php  $price .= '<td class="value courses_compare_id_'.$course->getIdentity().'">';
            $priceData = Engine_Api::_()->courses()->courseDiscountPrice($course);
            $price .= $priceData['discountPrice'] > 0 ? Engine_Api::_()->courses()->getCurrencyPrice($priceData['discountPrice']) : $this->translate("FREE");
           $price .= '</td>';
          ?>
         <?php  $description .= '<td class="value courses_compare_id_'.$course->getIdentity().'">'.$course->description.'</td>'; ?>
        <?php  $discount .= '<td class="value courses_compare_id_'.$course->getIdentity().'">';
           if($course->discount_type == 0){ 
              $discount .= $this->translate("%s%s OFF",str_replace('.00','',$priceData['discount']),"%");
             } else {
              $discount .= $this->translate("%s OFF",Engine_Api::_()->courses()->getCurrencyPrice($priceData['discount']));
             }
           $discount .= '</td>';
        ?>
        <?php  $categoriesData .= '<td class="value courses_compare_id_'.$course->getIdentity().'">';
           if (!empty($course->category_id)): 
           $category = Engine_Api::_ ()->getDbtable('categories', 'courses')->find($course->category_id)->current();
           if(isset($category)){ 
              $categoriesData .= '<a href="'.$category->getHref().'">'.$this->translate($category->category_name).'</a></td>';
             }
        endif; ?>
        <?php  $creationDate .= '<td class="value courses_compare_id_'.$course->getIdentity().'">'.$this->timestamp($course->modified_date, array()).'</td>'; ?>
        <?php $totalReviewCount = (int)Engine_Api::_()->getDbTable('reviews','courses')->getReviewCount(array('course_id'=>$course->getIdentity()))[0]; ?>
        <?php  $rating .= '<td class="value courses_compare_id_'.$course->getIdentity().'">'. $course->rating.' ('.$totalReviewCount.')'.'</td>'; ?>
        <?php  $duration .= '<td class="value courses_compare_id_'.$course->getIdentity().'">'.date('H:i:s',$course->getDuration()->duration).'</td>'; ?>
        <?php  $lectureCount .= '<td class="value courses_compare_id_'.$course->getIdentity().'">'.$course->lecture_count.'</td>'; ?>
        <?php  $testCount .= '<td class="value courses_compare_id_'.$course->getIdentity().'">'.$course->test_count.'</td>'; ?>
        <?php  $Owner .= '<td class="value courses_compare_id_'.$course->getIdentity().'">'.'&nbsp;'.$this->htmlLink($course->getOwner()->getHref(), $course->getOwner()->getTitle()).'</td>'; ?>
        <?php $count++; endforeach; ?>
         <?php if(isset($this->priceActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Price'); ?></td>
            <?php echo $price; ?>
          </tr>
        <?php } ?>
        <?php if(isset($this->discountActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Discount'); ?></td>
            <?php echo $discount; ?>
          </tr>
        <?php } ?>
        <?php if(isset($this->descriptionActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Description'); ?></td>
            <?php echo $description; ?>
          </tr>
        <?php } ?>
        <?php if(isset($this->categoryActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Category'); ?></td>
            <?php echo $categoriesData; ?>
          </tr>
        <?php } ?>
        <?php if(isset($this->creationDateActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Publish Date'); ?></td>
            <?php echo $creationDate; ?>
          </tr>
        <?php } ?> 
        <?php if(isset($this->durationActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Duration'); ?></td>
            <?php echo $duration; ?>
          </tr>
        <?php } ?> 
        <?php if(isset($this->ratingActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Rating & Reviews'); ?></td>
            <?php echo $rating; ?>
          </tr>
        <?php } ?> 
        <?php if(isset($this->lectureCountActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Total Lectures'); ?></td>
            <?php echo $lectureCount; ?>
          </tr>
        <?php } ?>
        <?php if(isset($this->testCountActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Total Tests'); ?></td>
            <?php echo $testCount; ?>
          </tr>
        <?php } ?>
        <?php if(isset($this->byActive)){ ?>
          <tr>
            <td class="heading"><?php echo $this->translate('Instructor Name'); ?></td>
            <?php echo $Owner; ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<script>
function removeCourseToCompare(course_id,category_id) {
  sesJqueryObject.post('courses/index/compare-course/type/remove',{category_id:category_id,course_id:course_id},function (res) {
    var courses = sesJqueryObject('#total_courses_compared').attr('data-courses');
    sesJqueryObject('.courses_compare_id_'+course_id).remove();
    if(parseInt(courses) <= 3)
      location.reload();
    else 
      sesJqueryObject('#total_courses_compared').attr('data-courses',parseInt(courses-1));
  });
}
</script>
