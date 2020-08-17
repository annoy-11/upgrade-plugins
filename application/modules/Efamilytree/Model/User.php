<?php

class Efamilytree_Model_User extends Core_Model_Item_Collection
{
    public function setPhoto($photo,$user_id)
    {
        if( $photo instanceof Zend_Form_Element_File ) {
            $file = $photo->getFileName();
            $fileName = $file;
        } else if( $photo instanceof Storage_Model_File ) {
            $file = $photo->temporary();
            $fileName = $photo->name;
        } else if( $photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id) ) {
            $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
            $file = $tmpRow->temporary();
            $fileName = $tmpRow->name;
        } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
            $file = $photo['tmp_name'];
            $fileName = $photo['name'];
        } else if( is_string($photo) && file_exists($photo) ) {
            $file = $photo;
            $fileName = $photo;
        } else {
            throw new User_Model_Exception('invalid argument passed to setPhoto');
        }

        if( !$fileName ) {
            $fileName = $file;
        }

        $name = basename($file);
        $extension = ltrim(strrchr(basename($fileName), '.'), '.');
        $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
        $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
        $params = array(
            'parent_type' => $this->getType(),
            'parent_id' => $this->getIdentity(),
            'user_id' => $user_id,
            'name' => basename($fileName),
        );

        // Save
        $filesTable = Engine_Api::_()->getDbtable('files', 'storage');

        // Resize image (main)
        $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
        $image = Engine_Image::factory();
        $image->open($file)
            ->autoRotate()
            ->resize(720, 720)
            ->write($mainPath)
            ->destroy();


        // Resize image (normal)
        $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_in.' . $extension;
        $image = Engine_Image::factory();
        $image->open($file)
            ->autoRotate()
            ->resize(140, 160)
            ->write($normalPath)
            ->destroy();

        // Store
        $iMain = $filesTable->createFile($mainPath, $params);
        $iIconNormal = $filesTable->createFile($normalPath, $params);

        $iMain->bridge($iIconNormal, 'thumb.normal');

        // Remove temp files
        @unlink($mainPath);
        @unlink($normalPath);

        $this->photo_id = $iMain->file_id;
        $this->save();
        return $this;
    }


}