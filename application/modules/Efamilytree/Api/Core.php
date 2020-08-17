<?php
class Efamilytree_Api_Core extends Core_Api_Abstract
{
  function generateFamilyTree($treeDatas,$content = "",$view,$createUl = false){
      foreach($treeDatas as $treeData){
          $content .= $view->partial('index/teedata.tpl', 'efamilytree', array("treeData"=>$treeData,'createUl'=>$createUl));
      }
      return $content;
  }
}
