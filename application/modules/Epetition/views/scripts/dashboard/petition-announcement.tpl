<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: petition-announcement.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<!--  Side menu   -->
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php if (!$this->is_ajax) {

echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition));
?>
<div class="epetition_dashbaord_announcement sesbasic_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    <p><?php echo $this->translate('This page allows you to create updates from Add Announcement button. The update will display on Profile page when the update widget and created announcements will display here and you can manage updates.'); ?></p><br />
    <!-- add button   -->
	<?php echo $this->htmlLink(array('route' => 'epetition_dashboard', 'module' => 'epetition', 'controller' => 'dashboard', 'action' => 'create-announcement', 'epetition_id' => $this->slug), $this->translate('<i class="fa fa-plus"></i> Add Announcement'), array('class'=>"sessmoothbox sesbasic_button")) ?>

    <script type="text/javascript">

        function multiDelete()
        {
            return confirm("<?php echo $this->translate('Are you sure you want to delete the selected petition entries?');?>");
        }

        function selectAll()
        {
            var i;
            var multidelete_form = $('multidelete_form');
            var inputs = multidelete_form.elements;
            for (i = 1; i < inputs.length; i++) {
                if (!inputs[i].disabled) {
                    inputs[i].checked = inputs[0].checked;
                }
            }
        }
    </script>
    
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

  <?php if( count($this->paginator) ): ?>
      <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
        <div class="epetition_dashboard_table">
          <table class='admin_table' style="width: 100%">
              <thead>
              <tr>
                  <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
<!--                  <th class='admin_table_short'>Id.</th>-->
                  <th><?php echo $this->translate("Title"); ?></th>
                  <th><?php echo $this->translate("Created By"); ?></th>
                  <th><?php echo $this->translate("Date"); ?></th>
                  <th><?php echo $this->translate("Action"); ?></th>
              </tr>
              </thead>
              <tbody>
              <?php $c=0; foreach ($this->paginator as $item): ?>
                  <tr id="announcement<?php echo $item->announcement_id; ?>">
                      <?php $user = Engine_Api::_()->getItem('user', $item->created_by); ?>
                      <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->announcement_id; ?>' value="<?php echo $item->announcement_id; ?>" /></td>
                      <!--<td><?php /*echo  $this->translate($item->announcement_id); */?></td>-->
                      <td><?php  echo  $this->translate($item->title); ?></td>
                      <td><?php  echo  $this->translate($user->getTitle()); ?></td>
                      <td><?php echo $this->translate(date("d/m/Y h:i A",strtotime($item->created_date)));  ?></td>
                      <td>
                          <a class='sessmoothbox' href='<?php echo $this->url(array('action' => 'edit-announcement', 'id' => $item->announcement_id));?>'>
                            <?php echo $this->translate("Edit"); ?>
                          </a>
                          |
                          <a class='sessmoothbox' href='<?php echo $this->url(array('action' => 'view-announcement', 'id' => $item->announcement_id));?>'>
                            <?php echo $this->translate("View"); ?>
                          </a>
                          |
                          <a href='javaScript:void(0);' onclick='redirectfordelete("<?php echo $this->url(array('action' => 'delete-announcement'));?>","<?php echo $item->announcement_id;?>")'>
                            <?php echo $this->translate("Delete"); ?>
                          </a>
                      </td>

                  </tr>
              <?php endforeach; ?>
              </tbody>
          </table>
          </div>
          <br />

          <div class='buttons'>
              <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
          </div>
      </form>

      <br/>
      <div>
        <?php echo $this->paginationControl($this->paginator); ?>
      </div>

  <?php else: ?>
      <div class="tip">
    <span>
      <?php echo $this->translate("There are no announcement entries for this petition.") ?>
    </span>
      </div>
  <?php endif; ?>
    <script>
        function redirectfordelete(url,id)
        {
            if(confirm('Are you sure to delete?'))
            {
                sesJqueryObject.ajax({
                    url: url,
                    type: "POST",
                    data: {id : id},
                    dataType: "json",
                    success: function(html) {
                        if (html['status']) {
                            sesJqueryObject("#announcement"+id).remove();
                            alert(html['msg']);
                        }
                        else
                        {
                            alert(html['msg']);
                        }
                    }
                });
            }
        }
    </script>
