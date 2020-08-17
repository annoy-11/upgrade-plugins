<rss version="2.0">
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html charset=utf-8" />
<channel>
  <title><?php echo $this->translate('Adanced Article Rss Feed');?></title>
    <description><?php echo $this->translate('Rss Feeds');?></description>
    <?php foreach($this->articles as $article):?>
    <item>
    	<?php 
      	$title = strip_tags($article->title);
        $title = str_replace("&rsquo;","'", $title); 
        $contentTitle = preg_replace("/&#?[a-z0-9]{2,8};/i","",$title );
       ?>
      <title><?php echo htmlspecialchars ($contentTitle);?></title>
      <link><?php echo "http://".$_SERVER['HTTP_HOST'].$this->url(array('action' => 'view','article_id'=>$article->custom_url), 'sesarticle_entry_view');?></link>
      <?php 
      	$content = preg_replace('/ +/', ' ',html_entity_decode(strip_tags($article->body)));
       ?>
      <description><?php echo Engine_Api::_()->sesarticle()->truncate(htmlspecialchars($content), 200,array('html' => true, 'ending' => '')) ?></description>
    </item>
  <?php endforeach;?>
</channel>
</rss>