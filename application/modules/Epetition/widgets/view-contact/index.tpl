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
<?php $allParams=isset($this->allParams['search_type']) ? $this->allParams['search_type'] : array(); ?>
<table class="epetition_profile_contact">
   <?php  if(in_array('contactname', $allParams)){ ?>
    <tr>
        <td><?php  echo $this->translate('Name'); ?></td>
        <td><?php  echo $this->epetition['petition_contact_name']; ?></td>
    </tr>
    <?php } ?>

  <?php  if(in_array('contactemail', $allParams)){ ?>
      <tr>
          <td><?php  echo $this->translate('Email'); ?></td>
          <td><?php  echo $this->epetition['petition_contact_email']; ?></td>
      </tr>
    <?php } ?>

  <?php  if(in_array('contactphonenumber', $allParams)){ ?>
      <tr>
          <td><?php  echo $this->translate('Phone'); ?></td>
          <td><?php  echo $this->epetition['petition_contact_phone']; ?></td>
      </tr>
  <?php } ?>

  <?php  if(in_array('contactfacebook', $allParams)){ ?>
      <tr>
          <td><?php  echo $this->translate('Facebook'); ?></td>
          <td><?php  echo $this->epetition['petition_contact_facebook']; ?></td>
      </tr>
  <?php } ?>

  <?php  if(in_array('contactlinkedin', $allParams)){ ?>
      <tr>
          <td><?php  echo $this->translate('Linkedin'); ?></td>
          <td><?php  echo $this->epetition['petition_contact_linkedin']; ?></td>
      </tr>
  <?php } ?>

  <?php  if(in_array('contacttwitter', $allParams)){ ?>
      <tr>
          <td><?php  echo $this->translate('Twitter'); ?></td>
          <td><?php  echo $this->epetition['petition_contact_twitter']; ?></td>
      </tr>
  <?php } ?>

  <?php  if(in_array('contactwebsite', $allParams)){ ?>
      <tr>
          <td><?php  echo $this->translate('Website'); ?></td>
          <td><?php  echo $this->epetition['petition_contact_website']; ?></td>
      </tr>
  <?php } ?>
</table>