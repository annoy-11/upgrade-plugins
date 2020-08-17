<?php
class Efamilytree_Model_DbTable_Users extends Engine_Db_Table
{

    protected $_rowClass = 'Efamilytree_Model_User';
    function getData($row = array(),$type = ""){
        $tree = array();

        $tree['user_id'] = $row[$type.'user_id'];
        if(!$row[$type.'deleted']) {
            if ($row[$type.'site_user_id']) {
                $tree['site_user_id'] = $row[$type.'site_user_id'];
                $user = Engine_Api::_()->getItem('user', $row[$type.'site_user_id']);
                if ($user) {
                    $tree['name'] = $user->getTitle();
                    $tree['href'] = $user->getHref().'/'.$user->getIdentity();
                    $tree['relation'] = !empty($row[$type.'relation']) ? $row[$type.'relation'] : "";
                    $photo = $user->getPhotoUrl() ;
                    $tree['image'] = $photo ? $photo : "application/modules/User/externals/images/nophoto_user_thumb_icon.png";
                }
            } else {
                $tree['name'] = $row[$type.'first_title'];
                $tree['relation'] = !empty($row[$type.'relation'])  ? $row[$type.'relation'] : "";
                $tree['gender'] = $row[$type.'gender'];
                $tree['email'] = $row[$type.'email'];
                $tree['phone_number'] = $row[$type.'phone_number'];
                $tree['dob'] = $row[$type.'dob'];
                $tree['href'] = 'javascript:;';
                if($type.'photo_id'){
                    $storage = Engine_Api::_()->getItem('storage_file',$row[$type.'photo_id']);
                    if($storage){
                        $photo = $storage->map();
                    }
                }else{
                    $photo = "";
                }
                $tree['image'] = !empty($photo) ? $photo : "application/modules/User/externals/images/nophoto_user_thumb_icon.png";
            }
        }else{
            $tree['relation'] = !empty($row[$type.'relation'])  ? $row[$type.'relation'] : "";
            $tree['name'] = "Deleted Member";
            $tree['href'] = 'javascript:;';
            $tree['image'] = "application/modules/User/externals/images/nophoto_user_thumb_icon.png";
        }
        return $tree;
    }
    function readNode($node_id, &$tree,$user_id = 0)
    {
        $row = $this->getNodeInfo($node_id,$user_id);
        if(($row)) {
            $parentNode = array();
            $tree['main'] = $this->getData($row,'');
            $spouse = $this->getData($row,'s_');
            if(!empty($spouse['name'])){
                $tree['spouse'] = $spouse;
                $parentNode[] = $tree['spouse']['user_id'];
            }
            $parentNode[] = $row->user_id;
            $children = $this->getNodeChildren($parentNode);
            $count = 0;
            foreach ($children as $child_id) {
                $this->readNode($child_id->user_id, $tree['contents'][$count]);
                $count++;
            }
        }else{
            //insert data
            $row = Engine_Api::_()->getDbTable("users",'efamilytree')->createRow();
            $params['owner_id'] = $user_id;
            $params['site_user_id'] = $user_id;
            $row->setFromArray($params);
            $row->save();
            $tree['main'] = $this->getData($row,'');
        }
    }
    public function getNodeInfo($node_id,$user_id = 0)
    {
        $columns = array('s.user_id as s_user_id','s.relative_id as s_relative_id','s.site_user_id as s_site_user_id','s.email as s_email','s.phone_number as s_phone_number'
        ,'s.dob as s_dob','s.first_title as s_first_title','s.gender as s_gender','s.photo_id as s_photo_id','s.deleted as s_deleted'
        );
        $select = $this->select()->from($this->info("name"));
        $select->joinLeft($this->info('name').' as s',$this->info('name').'.spouse_id = s.user_id',$columns);
        if($node_id)
            $select->where($this->info('name').'.user_id = ?',$node_id);
        else
            $select->where($this->info('name').'.owner_id = ?',$user_id);
        return $this->fetchRow($select);
    }
    public function getNodeChildren($node_id)
    {
        $select = $this->select()->from($this->info("name"));
        $select->where($this->info('name').'.parent_id IN (?)',$node_id);
        return $this->fetchAll($select);
    }
}