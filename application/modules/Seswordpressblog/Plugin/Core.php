<?php 
class Seswordpressblog_Plugin_Core
{
  public function onSesblogBlogCreateAfter($event)
  {	
  	 if(!empty($_SESSION["fromwptose"]))
  	 	return;
     $user = $event->getPayload();
     Engine_Api::_()->seswordpressblog()->sendDetails($user); 
  }
}
?>