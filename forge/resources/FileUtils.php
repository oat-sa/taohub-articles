<?php

namespace oat\taoDocs\helpers;

class FileUtils
{
    /**
     * @example use me to parse the data foldeer
     *
     * parse a folder and get it's files
     *
     *
     * @param object $path
     * @param object $recursive [optional]
     * @return the files list
     */
    public static function parseFolder($path, $recursive = false)
    {
        if (!self::securityCheck($path)) {
            throw new \Exception("Security error: folder '$path' parsing is not allowed");
        }

        $files = array();
        foreach (scandir($path) as $file) {
            if (!preg_match("/^\./", $file)) {
                $filePath = self::cleanConcat(array($path, $file));
                if (is_dir($filePath)) {
                    $files = array_merge($files, self::parseFolder($filePath));
                } else {
                    $files[$filePath] = $file;
                }
            }
        }

        return $files;
    }

    /**
     * delete folder and it's content
     * @param string $dir
     * @param boolean $recursive
     * @return boolean true if the folder doesn't exists anymore
     */
    public static function deleteFolder($dir, $recursive = false)
    {
        $files = glob($dir . "*", GLOB_MARK);
        foreach ($files as $file) {
            if (substr($file, -1) == '/') {
                if ($recursive) {
                    self::deleteFolder($file, true);
                }
            } else {
                self::deleteFile($file);
            }
        }
        if (is_dir($dir)) {
            rmdir($dir);
        }

        return !file_exists($dir);
    }

    /**
     * delete a file
     * @param string $file
     * @return boolean true if the file doesn't exists anymore
     */
    public static function deleteFile($file)
    {
        if (is_file($file)) {
            unlink($file);
        }

        return !file_exists($file);
    }

    /**
     * Check if the path in parameter contains unsafe data
     * @param string $path
     * @return boolean true if it's safe
     */
    public static function securityCheck($path)
    {
        //security check: detect directory traversal (deny the ../)
        if (preg_match("/\.\.\//", $path)) {

            return false;
        }

        //security check:  detect the null byte poison by finding the null char injection
        for ($i = 0; $i < strlen($path); $i++) {
            if (ord($path[$i]) === 0) {

                return false;
            }
        }

        return true;
    }

    /**
     * check if the path is a folder of refPath
     * @param string $refPath
     * @param string $path
     * @return boolean
     */
    public static function isFolder($refPath, $path)
    {
        if (!empty($refPath) && !empty($path) && is_string($refPath)) {
            do {
                if ($refPath == $path || $refPath == basename($path)) {

                    return true;
                }
                $refPath = dirname($refPath);
            } while ($refPath != '/' && $refPath != '' && $refPath != '.');
        }

        return false;
    }

    /**
     * Concat the path in the array in param
     * @param array $files
     * @return string contacted path
     */
    public static function cleanConcat(array $files)
    {
        $path = '';
        foreach ($files as $file) {
            if (!preg_match("/^\//", $file) && !preg_match("/\/$/", $path) && !empty($path)) {
                $path .= '/';
            }
            $path .= $file;
        }

        return $path;
    }

    /**
     * Get the mime type of the file in parameter
     * @param string $filename
     * @return the mime type
     */
    public static function getMimeType($filename)
    {

        $mime_types = array(

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

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.', $filename)));
        $mime_type = @mime_content_type($filename);
        if ($mime_type) {

            return $mime_type;
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);

            return $mimetype;
        } elseif (array_key_exists($ext, $mime_types)) {

            return $mime_types[$ext];
        } else {

            return 'application/octet-stream';
        }
    }
}