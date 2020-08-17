<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: send-messages.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Otpsms/views/scripts/dismiss_message.tpl';?>
<h2>Manage & Send Messages</h2>
<p>Below, you will find all the messages which you have sent to your users from this website in relation to OTP. You can use this page to monitor these Messages and modify them, if required. Entering criteria into the filter fields will help you find particular message(s). Leaving the filter fields blank will show all the messages on your social network.
</p>
<br>
<div class="sesbasic_search_result">
  <?php 
  echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'otpsms', 'controller' => 'settings', 'action' => 'send-message'), $this->translate('Send Message (SMS)'), array('class' => 'smoothbox buttonlink otpsms_icon_sms'));
  ?>
</div>


<div class='admin_search otpsms_sendsms_filter_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>

<br />

<div class='admin_results'>
  <div>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s sent message found.", "%s sent messages found.", $count),
        $this->locale()->toNumber($count)) ?>
  </div>
  <div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'pageAsQuery' => true,
      'query' => $this->formValues,
    )); ?>
  </div>
</div>

<br />

<div class="admin_table_form">
<form id='multimodify_form' method="post" action="" onSubmit="multiModify()">
  <table class='admin_table'>
    <thead>
      <tr>
        <th style='width: 1%;'><?php echo $this->translate("ID") ?></th>
        <th class="admin_table_centered"><?php echo $this->translate("Sent To") ?></th>
        <th style='width: 1%;'><?php echo $this->translate("Based On") ?></th>
        <th class='admin_table_centered'><?php echo $this->translate("Profile Type") ?></th>
        <th class='admin_table_centered'><?php echo $this->translate("Member Level") ?></th>
		<th class='admin_table_centered'><?php echo $this->translate("Message"); ?></th>
        <th style='width: 1%;' class='admin_table_options'><?php echo $this->translate("Creation Date") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ):
                  $user = $this->item('user', $item->user_id);
          ?>
          <tr>
			  <td><?php echo $item->sendmessage_id; ?></td>
            <td class='admin_table_bold admin_table_centered'>
			  <?php if(!empty($user->user_id)){ ?>
              <?php echo $this->htmlLink($user->getHref(),
                  $this->string()->truncate($user->getTitle(), 10),
                  array('target' => '_blank'))?>
			  <?php }else {echo "-";} ?>
            </td>
            <td class='admin_table_centered'>
				<?php if($item->parent_type == "profiletype"){ 
						  echo "Profile Types";
						}else{
						  echo "Member Levels";
						}
				?>  
			</td>
            <td class='admin_table_centered'>
              <?php if($item->parent_type == "profiletype"){ 
					if(!empty($item->type)){
						echo $this->profile_type[$item->type]; 
					}else {
						echo "All Profile Types";
					}	
				}else{
					echo "-";
				} ?>
            </td>
            <td class="admin_table_centered nowrap">
            	<?php if($item->parent_type != "profiletype"){ 
					if(!empty($item->type)){
						$level = Engine_Api::_()->getItem('authorization_level', $item->type);
						echo $level->getTitle();
					}else {
						echo "All Member Levels";
					}
				}else{
					echo "-";
				} ?>
            </td>
			<td class="admin_table_centered"><?php echo $item->message; ?></td>
            <td class='admin_table_centered'>
                <?php echo date('dS F Y ', strtotime($item->creation_date)) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <br />
  
</form>
</div>


<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="application/javascript">
sesJqueryObject('#starttime-hour, #starttime-minute, #starttime-ampm, #endtime-hour, #endtime-minute, #endtime-ampm').hide();
sesJqueryObject(document).on('change','#interval',function(e){
  var value = sesJqueryObject(this).val();
 
  if(value == 'specific'){
      sesJqueryObject('#starttime-wrapper, #endtime-wrapper').show();
  }else{
      sesJqueryObject('#starttime-wrapper, #endtime-wrapper').hide();
  }
});
sesJqueryObject('#interval').trigger('change');

sesJqueryObject(document).on('change','#type',function(e){
  var value = sesJqueryObject(this).val();
  if(value == 'memberlevel'){
    sesJqueryObject('#memberlevel').parent().show();
    sesJqueryObject('#profiletype').parent().hide();
  }else if(value == "profiletype"){
    sesJqueryObject('#memberlevel').parent().hide();
    sesJqueryObject('#profiletype').parent().show();
  }else{
    sesJqueryObject('#memberlevel').parent().hide();
    sesJqueryObject('#profiletype').parent().hide();
  }
});
sesJqueryObject('#type').trigger('change');

</script>