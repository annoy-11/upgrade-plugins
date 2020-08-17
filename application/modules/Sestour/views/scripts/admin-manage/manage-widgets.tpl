<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgets.tpl  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sestour/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected content ?") ?>");
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

<?php if( count($this->paginator) ): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()"> 
  <?php endif; ?>
  <div>
        <div class="sesbasic_search_reasult">
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'index'), $this->translate("Back to Manage Tours"), array('class'=>'sesbasic_icon_back buttonlink')); ?>
        </div>
        <h3><?php echo "Manage Tour Tips"; ?></h3>
        <p><?php echo $this->translate("Here you can add tips for the widgets placed on the page for which this tour has been created. For each tip, you can add  title, description.<br />You can also choose to redirect users to some other page by adding the URL for that page. To do so, you just have to enter the URL in the last tip of the tour of this page.<br /><br />Note : Tour Tips will not work for the widgets which are placed in tab container's More Tab.") ?>	 </p>
        <br />
        <div>

         <div class="sesbasic_search_reasult"><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'create-content','id'=>$this->tour_id, 'page_id' => $this->page_id), $this->translate("Add New Tip"), array('class'=>'buttonlink sesbasic_icon_add')); ?>
        </div>
      </div>
      <?php if( count($this->paginator) ): ?>
        <div class="sesbasic_search_reasult">
          <?php echo $this->translate(array('%s content found.', '%s contents found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
        </div><?php endif; ?>
        <?php if(count($this->paginator) > 0):?>
        	<div class="sestour_manage_table">
          	<div class="sestour_manage_table_head" style="width:100%;">
              <div style="width:5%">
                <input onclick='selectAll();' type='checkbox' class='checkbox' />
              </div>
              <div style="width:5%">
                <?php echo "Id";?>
              </div>
              <div style="width:20%">
               <?php echo $this->translate("Title") ?>
              </div>
              <div style="width:20%">
               <?php echo $this->translate("Widget Name") ?>
              </div>
              <div style="width:20%">
               <?php echo $this->translate("Class Name") ?>
              </div>
              <div style="width:10%" class="admin_table_centered">
               <?php echo $this->translate("Enabled") ?>
              </div>
              <div style="width:20%">
               <?php echo $this->translate("Options"); ?>
              </div>  
            </div>
          	<ul class="sestour_manage_table_list" style="width:100%;">
            <?php foreach ($this->paginator as $item) : ?>
              <li class="item_label">
                <div style="width:5%;">
                  <input type='checkbox' class='checkbox' name='delete_<?php echo $item->content_id;?>' value='<?php echo $item->content_id ?>' />
                </div>
                <div style="width:5%;">
                  <?php echo $item->content_id; ?>
                </div>
                <div style="width:20%;">
                  <?php echo $item->title ?>
                </div>
                <div style="width:20%;">
                  <?php echo $item->widget_name; ?>
                </div>
                <div style="width:20%;">
                  <?php echo $item->classname; ?>
                </div>
                <div style="width:10%;" class="admin_table_centered">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'enabled', 'tour_id' => $this->tour_id, 'id' => $item->content_id, 'page_id' => $this->page_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'enabled', 'tour_id' => $this->tour_id, 'id' => $item->content_id, 'page_id' => $this->page_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                </div>  
                <div style="width:20%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'create-content', 'content_id' => $item->content_id,'id'=>$this->tour_id, 'page_id' => $this->page_id), $this->translate("Edit"), array()) ?>
                  |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'delete-content', 'id' => $item->content_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          	<div class='buttons'>
            <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
          </div>
          </div>
        <?php else:?>
          <div class="tip">
            <span>
              <?php echo "There are no tips added by you yet.";?>
            </span>
          </div>
        <?php endif;?>
      </div>
  <br />
  </form>
  <br />
  <div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<style type="text/css">
.sestour_manage_form_head > div,
.sestour_manage_form_list li > div{
	box-sizing:border-box;
}
</style>