<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _appointments.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(count($this->appointmentPaginator)){   ?>
	<?php foreach ($this->appointmentPaginator as $item): ?>
  	<div class="sesapmt_myappointments_list_item sesbasic_clearfix">
    	<article class="sesbasic_clearfix">
      	<?php if($this->isProfessionalInAppointments==$item->professional_id){ ?>
        	<?php $userSelected = Engine_Api::_()->getItem('user',$item->user_id);?>
          <?php if($this->appointmentType=="given" || $this->appointmentType=="cancelled" || $this->appointmentType=="completed" || $this->appointmentType=="reject"){ ?>
          <div class="sesapmt_myappointments_list_item_thumb">
            <?php echo $this->htmlLink($userSelected->getHref(), $this->itemBackgroundPhoto($userSelected, 'thumb.profile', $userSelected->getTitle())) ?>
          </div>
          <div class="sesapmt_myappointments_list_item_info">
          	<p class="sesapmt_myappointments_list_item_title">
            	<?php echo $userSelected->displayname;?>
            </p>
            <p class="sesapmt_myappointments_list_item_det">
              <span class="sesbasic_text_light">Timing :</span>
              <span><?php echo date("d F Y (D)",strtotime($item->date))." ".date("h:i A",strtotime($item->professionaltime))." - ".date("h:i A",strtotime($item->serviceendtime)); ?></span>
            </p>
            <p class="sesapmt_myappointments_list_item_det">
            	<span class="sesbasic_text_light">Service :</span>
            	<span><?php $serviceName=Engine_Api::_()->getDbTable('services', 'booking')->getServices(array('service_id'=>$item->service_id));
              	echo $serviceName->name;?></span>
             </p>
             <?php if( $this->appointmentType!="cancelled" && $this->appointmentType!="completed" && $this->appointmentType!="reject"){ ?>
               <p class="sesapmt_myappointments_list_item_det floatL">
                <span class="sesbasic_text_light">Status :</span>
                <span><?php echo((!$item->action=="completed") ? "Pending" : ""); ?></span>
               </p>
               <p class="sesapmt_myappointments_list_item_btns floatR">
               	<?php if($item->professional_id==$item->given) { ?>
                	<span><a href="<?php echo $this->url(array("action"=>'appointment',"cancel"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Cancel</a></span>
                <?php } else { ?>
                <?php if($item->saveas==0){ ?>
                	<span><a href="<?php echo $this->url(array("action"=>'appointment',"accept"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Accept</a></span>
                <?php } else { ?>
                	<span><a href="<?php echo $this->url(array("action"=>'appointment',"completed"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Mark as Completed</a></span>
                <?php } ?>
                <span><a href="<?php echo $this->url(array("action"=>'appointment',"reject"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Reject</a></span>
                <?php /* if($item->block){  ?>
                	<span><a href="<?php echo $this->url(array("action"=>'appointment',"unblock"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Un Block</a></span>
                <?php } else { ?>
                	<span><a href="<?php echo $this->url(array("action"=>'appointment',"block"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Block</a></span>
                <?php  } */ ?>
                <?php } ?>
            		</p>
          		<?php } ?> 
            </div>
    		<?php } ?>
        <?php if(($this->isProfessionalInAppointments!=$item->user_id && $this->isProfessionalInAppointments==$item->user_id) && $this->appointmentType=="taken"){ ?>
        	<div class="tip"><span>There are currently no appointments to show.</span></div>
        <?php break; } ?>
        <?php } else if($this->isProfessionalInAppointments!=$item->professional_id){ ?>
        	<?php $userSelected = Engine_Api::_()->getItem('user',$item->professional_id); ?>
          	<?php if($this->appointmentType=="taken" || $this->appointmentType=="cancelled" || $this->appointmentType=="completed" || $this->appointmentType=="reject"){ ?>
            <div class="sesapmt_myappointments_list_item_thumb">
            	<?php echo $this->htmlLink($userSelected->getHref(), $this->itemBackgroundPhoto($userSelected, 'thumb.profile', $userSelected->getTitle())) ?>
          	</div>
            <div class="sesapmt_myappointments_list_item_info">
            	<p class="sesapmt_myappointments_list_item_title">
              	<?php echo $userSelected->displayname;?>
              </p>
              <p class="sesapmt_myappointments_list_item_det">
                <span class="sesbasic_text_light">Timing :</span>
                <span>
                	<?php 
                    /* getting my time zone */
                    date_default_timezone_set($item->professionaltimezone);
                    $professional = date("d-m-Y H:i:s");  
  
                    /* getting whose request me time zone */
                    date_default_timezone_set($item->usertimezone);
                    $viewer = date("d-m-Y H:i:s");  
  
                    $date1=date_create($professional);
                    $date2=date_create($viewer);
                    $diff=date_diff($date1,$date2);
                  ?>
                  <?php echo date("d F Y (D)", strtotime($diff->format("%R%a days %h hours %i minutes %s seconds"),strtotime($item->date)))." ".date("h:i A", strtotime($diff->format("%R%a days %h hours %i minutes %s seconds"),strtotime($item->professionaltime)))." - ".date("h:i A", strtotime($diff->format("%R%a days %h hours %i minutes %s seconds"),strtotime($item->serviceendtime))); ?>
                </span>
              </p>
							<p class="sesapmt_myappointments_list_item_det">
                <span class="sesbasic_text_light">Service :</span>
                <span><?php $serviceName=Engine_Api::_()->getDbTable('services', 'booking')->getServices(array('service_id'=>$item->service_id));
                    echo $serviceName->name;?></span>
             	</p>
              <?php  if( $this->appointmentType!="cancelled" && $this->appointmentType!="completed" && $this->appointmentType!="reject"){ ?>
                <p class="sesapmt_myappointments_list_item_det floatL">
                  <span class="sesbasic_text_light">Status :</span>
                  <span><?php echo(($item->saveas==1) ? "Your service request accepted by professional." : "Pending"); ?></span>
                 </p>
                 <p class="sesapmt_myappointments_list_item_btns floatR">
									<?php if($item->professional_id!=$item->given) { ?>
                  	<span><a href="<?php echo $this->url(array("action"=>'appointment',"cancel"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Cancel</a></span>
                  <?php } else { ?>
                  	<?php if($item->saveas==0){ ?> 
                    <span>
                      <?php //if member level have enable online payment. ?>
                      <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
                      <?php if($settings->getSetting('booking.paymode')){ ?>
                        <a href="<?php echo $this->url(array("action"=>'appointment',"accept"=>$item->appointment_id,"professional_id" => $item->professional_id, "order_id" => $item->order_id),'booking_general',true); ?>" class="openSmoothbox">Accept and Pay</a>
                      <?php }else{ ?>
                        <a href="<?php echo $this->url(array("action"=>'appointment',"accept"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Accept</a>
                      <?php } ?>
                    </span>
                    <?php } else { ?>
                      <span><a href="<?php echo $this->url(array("action"=>'appointment',"completed"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Mark as Completed</a></span>
                    <?php } ?>
                      <span><a href="<?php echo $this->url(array("action"=>'appointment',"reject"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Reject</a></span>
                    <?php /* if($item->block){ ?>
                      <span><a href="<?php echo $this->url(array("action"=>'appointment',"unblock"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Un Block</a></span>
                    <?php } else { ?>
                      <span><a href="<?php echo $this->url(array("action"=>'appointment',"block"=>$item->appointment_id),'booking_general',true); ?>" class="openSmoothbox">Block</a></span>
                    <?php } */ ?>
                  <?php } ?>
                 </p>
               <?php } ?>
            </div>
        	<?php } ?>
        	<?php if(($this->isProfessionalInAppointments!=$item->user_id && $this->isProfessionalInAppointments==$item->user_id) && $this->appointmentType=="given"){ ?>
          	<div class="tip"><span>?>There are currently no appointments to show.</span></div>
        	<?php break; } ?>
        <?php }?>
     	</article>   
    </div>
	<?php endforeach; ?>
<?php } else { ?>
    <div class="tip"><span>There are currently no appointments to show.</span></div>
<?php } ?>