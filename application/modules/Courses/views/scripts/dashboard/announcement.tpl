<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: announcement.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'courses', array('course' => $this->course));	
?>
	<div class="courses_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php }  ?>
<?php ?>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    $$('th.admin_table_short input[type=checkbox]').addEvent('click', function(event) {
      var el = $(event.target);
      $$('input[type=checkbox]').set('checked', el.get('checked'));
    });
  });
  var changeOrder =function(orderby, direction){
    $('orderby').value = orderby;
    $('orderby_direction').value = direction;
    $('filter_form').submit();
  }
  var delectSelected =function(){
    var checkboxes = $$('input[type=checkbox]');
    var selecteditems = [];
    checkboxes.each(function(item, index){
      var checked = item.get('checked');
      var value = item.get('value');
      if (checked == true && value != 'on'){
        selecteditems.push(value);
      }
    });
    $('ids').value = selecteditems;
    $('delete_selected').submit();
  }
  function makeEditorRich() {
    tinymce.init({
      mode: "specific_textareas",
      plugins: "table,fullscreen,media,preview,paste,code,image,textcolor,jbimages,link",
      theme: "modern",
      menubar: false,
      statusbar: false,
      toolbar1:  "undo,redo,removeformat,pastetext,|,code,media,image,jbimages,link,fullscreen,preview",
      toolbar2: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,forecolor,backcolor,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,outdent,indent,blockquote",
      toolbar3: "",
      element_format: "html",
      height: "225px",
      content_css: "bbcode.css",
      entity_encoding: "raw",
      add_unload_trigger: "0",
      remove_linebreaks: false,
      convert_urls: false,
      language: "<?php echo $this->language; ?>",
      directionality: "<?php echo $this->direction; ?>",
      upload_url: "<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'index', 'action' => 'upload-image'), 'default', true); ?>",
      editor_selector: "tinymce"
    });
  }
</script>
    <div class="courses_dashboard_content_header">
      <h3><?php echo $this->translate('Manage Announcements') ?></h3>
    	<p><?php echo $this->translate('Here, you can create announcements to post them on the Classroom Profile. You can also edit and delete the announcements listed on this courses.') ?></p>
    </div>
    <br />
    <div class="courses_dashboard_content_btns">
      <a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'post-announcement'), 'courses_dashboard', true); ?>" class="sessmoothbox sesbasic_button" style="display:inline-block;"><i class="fa fa-bullhorn"></i><span><?php echo $this->translate("Post New Announcement");?></span></a>
    </div>  
       <br />
  <?php if($this->paginator->getTotalItemCount()!=0): ?>
    <div class="courses_dashboard_results"><?php echo $this->translate('%d announcements total', $this->paginator->getTotalItemCount()) ?></div>
  <?php endif;?>
  <?php echo $this->paginationControl($this->paginator); ?>
<?php if( count($this->paginator) ): ?>
  <div class="courses_dashboard_table">
    <table class='admin_table'>
      <thead>
        <tr>
          <th style="width: 1%;" class="admin_table_short"><input type='checkbox' class='checkbox'></th>
          <th style="width: 1%;"><a href="javascript:void(0);" onclick="javascript:changeOrder('announcement_id', '<?php if($this->orderby == 'announcement_id') echo "DESC"; else echo "ASC"; ?>');">
            <?php echo $this->translate("ID") ?>
          </a></th>
          <th style="width: 70%;"><a href="javascript:void(0);" onclick="javascript:changeOrder('title', '<?php if($this->orderby == 'title') echo "DESC"; else echo "ASC"; ?>');">
            <?php echo $this->translate("Title") ?>
          </a></th>
          <th style="width: 15%;"><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', '<?php if($this->orderby == 'creation_date') echo "DESC"; else echo "ASC"; ?>');">
            <?php echo $this->translate("Creation Date") ?>
          </a></th>
          <th style="width: 15%;">
            <?php echo $this->translate("Options") ?>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <tr>
          <td><input type='checkbox' class='checkbox' value="<?php echo $item->announcement_id?>"></td>
          <td><?php echo $item->announcement_id ?></td>
          <td class="admin_table_bold"><?php echo $item->title ?></td>
          <td><?php echo $this->locale()->toDateTime( $item->creation_date ) ?></td>
          <td class="admin_table_options">
            <?php echo $this->htmlLink(
              array('action' => 'edit-announcement', 'id' => $item->getIdentity(), 'reset' => false), $this->translate(''),array('class' => 'sessmoothbox sesbasic_button fa sesbasic_icon_edit')) ?>
            <?php echo $this->htmlLink(array('action' => 'delete-announcement', 'id' => $item->getIdentity(), 'reset' => false),$this->translate(''),array('class' => 'sessmoothbox sesbasic_button fa sesbasic_icon_delete')) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class='ecourses_dashboard_content_btns'>
    <button onclick="javascript:delectSelected();" type='submit'>
      <?php echo $this->translate("Delete Selected") ?>
    </button>
  </div>
  <form id='delete_selected' method='post' action='<?php echo $this->url(array('action' =>'delete-announcement')) ?>'>
    <input type="hidden" id="ids" name="ids" value=""/>
  </form>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are currently no announcements.") ?>
    </span>
  </div>
<?php endif; ?>
<?php if(!$this->is_ajax) { ?>
	</div>
</div>
<?php } ?>
