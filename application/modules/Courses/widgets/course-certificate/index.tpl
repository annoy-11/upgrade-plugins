<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Courses/externals/styles/certificate.css" rel="stylesheet" media="print" type="text/css" />
 <?php  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/certificate.css'); ?>
<div class="certificate">
   <div class="certificate-inner">
      <div class="main-content">
         <img src="application/modules/Courses/externals/images/logo.png">
         <h2>CERTIFICATE OF COMPLETION</h2>
         <p>This Certificate is awarded to<br><span class="name">john doe</span><br>This is Certify that John Doe has successfully
            completed <b>Java Course</b> on <b>30 Sepetember,2019.</b>
         </p>
         <div class="signature-footer">
            <ul class="list-unstyled">
               <li>
                  <span class="signature">John Doe</span>
                  <span class="color-line"></span><br>
                  <span class="sign-label">Instructor Name</span>
               </li>
            </ul>
         </div>
         <div class="number-link">
            <a href="#" class="serial-number"><strong>Serial No</strong><br>000-000-001</a>
         </div>
      </div>
   </div>
 </div>