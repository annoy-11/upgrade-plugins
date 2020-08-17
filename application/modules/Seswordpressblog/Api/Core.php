<?php

class Seswordpressblog_Api_core extends Core_Api_Abstract{
    function  sendDetails($user){
         $id=Engine_Api::_()->user()->getViewer()->getIdentity();
         $db = Zend_Db_Table_Abstract::getDefaultAdapter();
         $results = $db->query("SELECT category_name FROM engine4_sesblog_categories WHERE category_id = ".$_POST['category_id'])->fetchAll();
         if(!empty($_POST)){
             $title=$_POST['title'];
             $description=$_POST['body'];
             $image_url=$_POST['from_url'];
             $tags=$_POST['tags'];
             $category=$results[0]['category_name'];
         }
         $data=array();
             $data['blogid']=$id;
             $data['title']=$title;
             $data['description']=$description;
             $data['image_url']=$image_url;
             $data['tags']=$tags;
             $data['category']=$category;
             $url="http://client.testing.com/devswordpress/";
             $url = $url.'?onSesblogBlogCreateAfter=getSesblogToWp';
             $ch = curl_init($url);
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
             $result = trim(curl_exec($ch),' ');
             if($result!="done"){
                 echo "!!!error".$result;die;
             }
    }
}
?>
