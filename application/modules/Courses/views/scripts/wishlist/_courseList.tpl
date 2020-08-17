<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _courseList.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $courses = $this->wishlist->getCourses(); ?>
<div>
  <?php if (!empty($courses)): ?>
    <ul id="courses_playlist">
      <?php foreach ($courses as $course): 
      	$courseMain = Engine_Api::_()->getItem('courses', $course->course_id);
      ?>
      <li id="song_item_<?php echo $course->wishlist_id ?>" class="file file-success">
        <a href="javascript:void(0)" class="course_action_remove file-remove"><?php echo $this->translate('Remove') ?></a>
        <span class="file-name">
          <?php echo $courseMain->getTitle() ?>
        </span>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>
<script type="text/javascript">
  en4.core.runonce.add(function(){
    $('demo-status').style.display = 'none';
    if ($$('#courses_playlist li.file').length) {
      $$('#courses_playlist li.file').inject($('demo-list'));
      $('demo-list').show()
    }
    
});
//REMOVE/DELETE SONG FROM PLAYLIST
    sesJqueryObject('.course_action_remove').click(function(){
      var course_id  = sesJqueryObject(this).parent().attr('id').split(/_/);
          course_id  = course_id[ course_id.length-1 ];
      sesJqueryObject(this).parent().remove();
      new Request.JSON({
        url: '<?php echo $this->url(array('module'=> 'courses' ,'controller'=>'wishlist','action'=>'delete-playlistcourse'), 'default') ?>',
        data: {
          'format': 'json',
          'playlistcourse_id': course_id,
          'wishlist_id': <?php echo $this->wishlist->wishlist_id ?>
        }
      }).send();
      return false;
    });
</script>
