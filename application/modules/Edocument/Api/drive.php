<?php

include APPLICATION_PATH.DS.'application'.DS.'modules'.DS.'Edocument'.DS.'Api'.DS.'vendor/autoload.php';
//http://hookr.io/plugins/google-drive-wp-media/2.4.2/classes/gdwpmbantuan/

class Drive
{
    protected $scope = array('https://www.googleapis.com/auth/drive');
    private $_service;
    protected $_client;
    protected $_error;

    public function __construct( $serviceAccountName = "Google Drive Upload", $createLink = null) {

        $this->_client = new Google_Client();
        $base = Zend_Controller_Front::getInstance()->getBaseUrl();
        $url = ((!empty($_ENV["HTTPS"]) && 'on' == strtolower($_ENV["HTTPS"])) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $base . '/admin/edocument/settings';
        $this->_client->setApplicationName($serviceAccountName);
        $this->_client->setClientId(Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument_client_id'));
        $this->_client->setClientSecret(Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument_secret_key'));
        $this->_client->setRedirectUri($url);
        $this->_client->setScopes($this->scope);

        if ($createLink) {
            $this->_client->setAccessType('offline');
            $this->_client->setApprovalPrompt('force');
            $auth_url = $this->_client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $refreshToken = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.google.refreshtoken');
            if (isset($_GET['code']) && !$refreshToken) {
                $this->_service = new Google_Service_Drive($this->_client);
                $this->_client->authenticate($_GET['code']);
                $token = ($this->_client->getAccessToken());
                Engine_Api::_()->getApi('settings', 'core')->setSetting('edocument.google.refreshtoken', $token['refresh_token']);
                $tokens = $this->_client->getAccessToken();
                $this->_client->setAccessToken($tokens);
            } else {
                if ($refreshToken) {
                    $this->_client->refreshToken($refreshToken);
                    $tokens = $this->_client->getAccessToken();
                    $this->_client->setAccessToken($tokens);
                }
                $this->_service = new Google_Service_Drive($this->_client);
            }
        }
    }

    public function getAboutError() {
        if (isset($this->_error)) {
            if(!empty($this->_error))
                return $this->_error;
            else
                return "Drive quota full.";
        }
        return false;
    }

    public function getInfo() {
        try {
            return $this->_service->about->get(array('fields' => "storageQuota"));
        } catch (Exception $e) {
            $this->_error = $e->getMessage();
            return false;
        }
    }

    public function deleteFile($id) {
        if (empty($this->_service->files->delete($id))) {
            return true;
        } else {
            return false;
        }
    }
    function uploadFile($path, $fileName, $description, $fileParent = null, $mimeType, $restricted = false)
    {
        $file = new Google_Service_Drive_DriveFile(array('parents'=>$fileParent));
        $file->setName($fileName);
        $file->setDescription($description);
        $file->setMimeType($mimeType);
        if ($fileParent) {
            $file->setParents(array($fileParent));
        }

        $labelrestricted = $restricted ? 'false' : 'true';
        $labels = new Google_Service_Drive_DriveFileLabels();
        $labels->setRestricted($labelrestricted);
        $file->setLabels($labels);

        $this->_client->setDefer(true);
        $c = array('local' => array('cekbok' => 'checked', 'chunk' => '700', 'retries' => '3'), 'drive' => array('cekbok' => 'checked', 'chunk' => '2', 'retries' => '3'));

        $chunks = $c['drive']['chunk'];
        $max_retries = (int)$c['drive']['retries'];
        $chunkSize = (1024 * 1024) * (int)$chunks; // 2mb chunk
        $mkFile = $this->_service->files->create($file);
        $fileupload = new Google_Http_MediaFileUpload($this->_client, $mkFile, $mimeType, null,true, $chunkSize);
        $fileupload->setFileSize(filesize($path));
        $status = false;
        $handle = fopen($path, "rb");
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSize);
            $status = $fileupload->nextChunk($chunk);
        }
        fclose($handle);
        $this->_client->setDefer(false);
        $result = false;
        if($status != false) {
            return $status['id'];
        } else {
            return false;
        }
    }

    function getFileType($filename)
    {
        if (!function_exists('mime_content_type')) {
            return $this->get_mime_type($filename);
        } else {
            return mime_content_type($filename);
        }
    }

    function get_mime_type($filename)
    {
        $idx = explode('.', $filename);
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode - 1]);

        $mimet = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',


            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        if (isset($mimet[$idx])) {
            return $mimet[$idx];
        } else {
            return 'application/octet-stream';
        }
    }

    function getFolder($email)
    {
        $folder = $this->getUserFolder($email);
        if (!$folder) {
            return $this->createNewFolder($email);
        }
        return $folder;
    }

    function createNewFolder($name)
    {
        $file = new Google_Service_Drive_DriveFile();
        $file->setName($name);
        $file->setMimeType('application/vnd.google-apps.folder');

        $createdFolder = $this->_service->files->create($file, array('mimeType' => 'application/vnd.google-apps.folder'));
        return $createdFolder['id'];
    }

    function setPermissions($fileId, $email , $role = 'writer', $type = 'user')
    {
        $perm = new Google_Service_Drive_Permission();
        if($email != "me")
        $perm->setEmailAddress($email);
        $perm->setType($type);
        $perm->setRole($role);
        return $this->_service->permissions->create($fileId, $perm);
    }

    function getUserFolder($name)
    {
        $parameters = array('q' => "mimeType = 'application/vnd.google-apps.folder'", 'pageSize' => 50);
        $files = $this->_service->files->listFiles($parameters);
        foreach ($files['files'] as $item) {
            if ($item['name'] == $name) {
                return $item['id'];
                break;
            }
        }
        return false;
    }
}
