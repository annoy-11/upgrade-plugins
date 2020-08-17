<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2>
  <?php echo $this->translate("Advanced Videos & Channels - Video Importer & Search Extension") ?>
</h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'settings', 'action' => 'contact-us'),'admin_default',true); ?>" class="request-btn">Feature Request</a>
</div>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
  </div>
<?php endif; ?>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to import videos."); ?>
    <i></i>
  </div>
</div>
<div id="video_message" class="clear sesvideo_import_msg sesvideo_import_error"></div>
<div id="video_message1" class="clear sesvideo_import_msg sesvideo_import_success"></div>
<div class="sesbasic_manage_table">
          	<div class="sesbasic_manage_table_head" style="width:100%;">
              <div style="width:5%">
                <?php echo "Id";?>
              </div>
              <div style="width:45%">
               <?php echo $this->translate("Site Title") ?>
              </div>
              <div style="width:25%"  class="">
               <?php echo $this->translate("Modified Date") ?>
              </div>
              <div style="width:25%">
               <?php echo $this->translate("Options"); ?>
              </div>  
            </div>
          	<ul class="sesbasic_manage_table_list" style="width:100%;">
            <?php foreach ($this->paginator as $item) : ?>
              <li class="item_label" id="slide_<?php echo $item['import_id']; ?>">
                <div style="width:5%;">
                  <?php echo $item['import_id']; ?>
                </div>
                <div style="width:45%;">
                  <?php echo $item['type'] ?>
                </div>
                <div style="width:25%;" class="">
                  <?php echo $item['modified_date']; ?>
                </div> 
                <div style="width:25%;" class="">
                	<?php $type = $item['type']; 
                  			$id = $item["import_id"];
                  ?>
                  <?php if(!$item['file_path'] && ($item['type'] == 'pornhub')){ ?>
                  		<form id="pornhub_form" method="post" enctype="multipart/form-data">
                      	<input type="hidden" name="pornhub_id" value="<?php echo $id ?>" />
                      	<input type="file" name="pornhub" id="pornhub_file" onchange="readUrl(this,'pornhub')" style="display:none;" />
                  			<a href="javascript:;" class="uploadcsv" data-rel="pornhub" title="Upload New Csv">Upload New Csv</a>
                      </form>
                  <?php } else if(!$item['file_path'] && ($item['type'] == 'xtube')){ ?>
                  		<form id="xtube_form" method="post" enctype="multipart/form-data">
                      	<input type="hidden" name="xtube_id" value="<?php echo $id ?>" />
                      	<input type="file" name="xtube" id="xtube_file" onchange="readUrl(this,'xtube')" style="display:none;" />
                  			<a href="javascript:;" class="uploadcsv" data-rel="xtube" title="Upload New Csv">Upload New Csv</a>
                      </form>
                  <?php }else{ ?>
                  	<a href="javascript:;" onclick="return importFn('<?php echo $type ?>','<?php echo $id; ?>');">Start Import</a>
                  <?php } ?>
                  <?php if($item['file_path'] && $item['type'] == 'pornhub'){ ?>
                  		<form id="pornhub_form" method="post" enctype="multipart/form-data" style="display:inline-block;">
                      	<input type="hidden" name="pornhub_id" value="<?php echo $id ?>" />
                      	<input type="file" name="pornhub" id="pornhub_file" onchange="readUrl(this,'pornhub')" style="display:none;" />
                        <?php $data = explode('_',$item['file_path']); 
                        			unset($data[0]);
                        ?>
                  			 | <a href="javascript:;" class="uploadcsv" data-rel="pornhub" title="Click to upload new Csv"><?php echo implode('_',$data); ?></a>
                      </form>
                  <?php } ?>
                  <?php if($item['file_path'] && $item['type'] == 'xtube'){ ?>
                  		<form id="xtube_form" method="post" enctype="multipart/form-data" style="display:inline-block;">
                      	<input type="hidden" name="xtube_id" value="<?php echo $id ?>" />
                      	<input type="file" name="xtube" id="xtube_file" onchange="readUrl(this,'xtube')" style="display:none;" />
                        <?php $data = explode('_',$item['file_path']); 
                        			unset($data[0]);
                        ?>
                  			 | <a href="javascript:;" class="uploadcsv" data-rel="xtube" title="Click to upload new Csv"><?php echo implode('_',$data); ?></a>
                      </form>
                  <?php } ?>
                </div>                
              </li>
            <?php endforeach; ?>
          </ul>
          </div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<script type="application/javascript">
function importFn(type,id){
	sesJqueryObject('.sesbasic_waiting_msg_box').show();
	en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'admin/sesvideoimporter/manage/'+type+'/id/'+id,
      method: 'get',
      data: {
        'format': 'json',
      },
      onSuccess: function(responseJSON) {
				sesJqueryObject('.sesbasic_waiting_msg_box').hide();
        if (responseJSON.error_code != 0) {
          $('video_message').innerHTML = "<span>Some error might have occurred during the import process. Please refresh the page and click on 'Start Importing' again to complete the import process.</span>";
        } else {
          $('video_message').style.display = 'none';
          $('video_message1').innerHTML = "<span>" + '<?php echo $this->string()->escapeJavascript($this->translate("Video have been imported successfully.")) ?>' + "</span>";
        }
      }
    }));	
}
sesJqueryObject(document).on('click','.uploadcsv',function(){
	var id = sesJqueryObject(this).attr('data-rel');
	if(id == 'xtube') 
	{
    sesJqueryObject('#xtube_file').trigger('click');
	} else {
	sesJqueryObject('#pornhub_file').trigger('click');
	}
});
function readUrl(input,id) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "csv")) {
     console.log(input.files[0]);
		 sesJqueryObject('#'+id+'_form').trigger('submit');
    }
  }
</script>