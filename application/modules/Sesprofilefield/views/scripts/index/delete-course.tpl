<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-course.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_course', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_course_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('course_id', <?php echo $this->course_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-course/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_course_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='coursesuccess_message' class='sesprofilefield_success_message coursesuccess_message'><i class='fa-check-circle-o'></i><span>Your course is successfully added.</span></div>");
        sesJqueryObject('#coursesuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_course_<?php echo $this->course_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
        if(sesJqueryObject('#course_count').length) {
          var countType = sesJqueryObject('#course_count').html();
          sesJqueryObject('#course_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_course_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
	<?php echo $this->form->render($this) ?>
<?php } ?>
</div>
