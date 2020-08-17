<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
  <?php if($this->widgetIdentity):?>
    <?php $randonnumber = $this->widgetIdentity;?> 
  <?php else:?>
    <?php $randonnumber = $this->identity;?>
  <?php endif;?>
<?php echo $photo_type=$this->photo_type;  ?>
  <div class="epetition_top_petitioner_list" style="position:relative;">
    <?php if($this->view_type == 'Vertical'):?>
      <ul id="widget_epetition_<?php echo $randonnumber; ?>" class="epetition_top_petitioners sesbasic_sidebar_block  sesbasic_clearfix sesbasic_bxs">
        <div class="sesbasic_loading_cont_overlay" id="epetition_widget_overlay_<?php echo $randonnumber; ?>"></div>
        <?php foreach( $this->paginator as $petitionger ): ?>
          <?php $item = Engine_Api::_()->getItem('user',$petitionger->user_id);?>
          <li class="epetitioner_top_sidebar_list">
              <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.icon'), array('class' => 'epetition_top_petition_thumb')) ?>
            <div class="epetition_top_petition_info">
              <?php if(isset($this->ownernameActive)):?>
                <div class="epetition_top_petition_title">
                  <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
                </div>
              <?php endif;?>
              <?php if(isset($this->countActive)):?>
                <div class="epetition_top_petition_list_stats">
                  <?php echo $this->translate('Total Petition:');?>
                  <b><?php echo $petitionger->petition_count; ?></b>
                </div>
              <?php endif;?>
            </div>
          </li>
        <?php endforeach; ?>
        <?php if(isset($this->widgetName)){ ?>
          <div class="sidebar_privew_next_btns">
            <div class="sidebar_previous_btn">
              <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
                'id' => "widget_previous_".$randonnumber,
                'onclick' => "widget_previous_$randonnumber()",
                'class' => 'buttonlink_left previous_icon'
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
    <?php else:?>
      <ul id="widget_epetition_<?php echo $randonnumber; ?>" class="epetition_top_petitioners sesbasic_clearfix sesbasic_bxs">
        <div class="sesbasic_loading_cont_overlay" id="epetition_widget_overlay_<?php echo $randonnumber; ?>"></div>
        <?php foreach( $this->paginator as $petitionger ): ?>
          <?php $item = Engine_Api::_()->getItem('user',$petitionger->user_id);?>
          <li class="epetition_top_grid_list" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
          <div class="epetition_top_grid_thumb_petition" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
            <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.profile'), array('class' => 'epetition_top_petition_thumb')) ?>
            </div>
            <?php if(isset($this->ownernameActive) || isset($this->countActive)):?>
              <div class="epetition_top_petition_info">
                <?php if(isset($this->ownernameActive)):?>
                  <div class="epetition_top_petition_title">
                    <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
                  </div>
                <?php endif;?>
                <?php if(isset($this->countActive)):?>
                  <div class="epetition_top_petition_list_stats">
                    <?php echo $this->translate('Total Petition:');?>
                    <b><?php echo $petitionger->petition_count; ?></b>
                  </div>
              <?php endif;?>
              </div>
            <?php endif;?>
          </li>
        <?php endforeach; ?>
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
    <?php endif;?>
  </div>
  <?php if(isset($this->widgetName)){ ?>
    <script type="application/javascript">
      var anchor_<?php echo $randonnumber ?> = sesJqueryObject('#widget_epetition_<?php echo $randonnumber; ?>').parent();
      function showHideBtn<?php echo $randonnumber ?> (){
        sesJqueryObject('#widget_previous_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>');
        sesJqueryObject('#widget_next_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' ) ?>');	
      }
      showHideBtn<?php echo $randonnumber ?> ();
      function widget_previous_<?php echo $randonnumber; ?>(){
        sesJqueryObject('#epetition_widget_overlay_<?php echo $randonnumber; ?>').show();
        new Request.HTML({
          url : en4.core.baseUrl + 'widget/index/mod/epetition/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
          data : {
            format : 'html',
            is_ajax: 1,
            params :'<?php echo json_encode($this->params); ?>', 
            page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() - 1) ?>
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            anchor_<?php echo $randonnumber ?>.html(responseHTML);
            sesJqueryObject('#epetition_widget_overlay_<?php echo $randonnumber; ?>').hide();
            showHideBtn<?php echo $randonnumber ?> ();
          }
        }).send()
      };
  
      function widget_next_<?php echo $randonnumber; ?>(){
        sesJqueryObject('#epetition_widget_overlay_<?php echo $randonnumber; ?>').show();
        new Request.HTML({
          url : en4.core.baseUrl + 'widget/index/mod/epetition/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
          data : {
            format : 'html',
            is_ajax: 1,
            params :'<?php echo json_encode($this->params); ?>' , 
            page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            anchor_<?php echo $randonnumber ?>.html(responseHTML);
            sesJqueryObject('#epetition_widget_overlay_<?php echo $randonnumber; ?>').hide();
            showHideBtn<?php echo $randonnumber ?> ();
          }
        }).send();
      };
    </script>
  <?php } ?>