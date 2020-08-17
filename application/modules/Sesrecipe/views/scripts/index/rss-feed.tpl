<rss version="2.0">
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html charset=utf-8" />
<channel>
  <title><?php echo $this->translate('Adanced Recipe Rss Feed');?></title>
    <description><?php echo $this->translate('Rss Feeds');?></description>
    <?php foreach($this->recipes as $recipe):?>
    <item>
    	<?php 
      	$title = strip_tags($recipe->title);
        $title = str_replace("&rsquo;","'", $title); 
        $contentTitle = preg_replace("/&#?[a-z0-9]{2,8};/i","",$title );
       ?>
      <title><?php echo htmlspecialchars ($contentTitle);?></title>
      <link><?php echo "http://".$_SERVER['HTTP_HOST'].$this->url(array('action' => 'view','recipe_id'=>$recipe->custom_url), 'sesrecipe_entry_view');?></link>
      <?php 
      	$text = strip_tags($recipe->body);
        $text = str_replace("&rsquo;","'", $text); 
        $content = preg_replace("/&#?[a-z0-9]{2,8};/i","",$text );
       ?>
      <description><?php echo Engine_Api::_()->sesrecipe()->truncate(htmlspecialchars($content), 200,array('html' => true, 'ending' => '')) ?></description>
    </item>
  <?php endforeach;?>
</channel>
</rss>