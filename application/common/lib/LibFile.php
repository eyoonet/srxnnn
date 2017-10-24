<?php
namespace app\common\lib;
class LibFile
{
    /**
     * 获取目录下所有图片
     * @param $path
     * @return array
     */
    public static function getImageByNames($path)
    {
        $path = self::formatePath($path);
        if (is_dir($path)) {
            $dir = opendir($path);
        } else {
            return;
        }
        $files = [];
        while (($filename = readdir($dir)) !== FALSE) {
            if ($filename != '.' && $filename != '..') {
                if (preg_match("/\.(gif|jpeg|jpg|png|bmp)$/i", $filename)) {
                    $files[] = iconv('gbk', 'utf-8', $filename);
                }
            }
        }
        closedir($dir);
        return $files;
    }
    /**
     * 获取目录下所有文件
     * @param $path
     * @return array
     */
    public static function getFiles($path)
    {
        $path = self::formatePath($path);
        $dir = opendir($path);
        $files = [];
        while (($filename = readdir($dir)) !== FALSE) {
            if ($filename != '.' && $filename != '..') {
                $files[] = $path . $filename;
            }
        }
        closedir($dir);
        return $files;
    }

    /**
     * 按模式取目录下文件
     * @param $path
     * @param $pattern
     * @return array
     */
    public static function getFilesByPattern($path, $pattern)
    {
        $path = self::formatePath($path);
        $filePattern = sprintf('%s%s', $path, $pattern);
        return glob($filePattern);
    }

    /**
     * 获取最后修改时间
     * @param $path
     * @return int
     */
    public static function getModifiedTime($path)
    {
        return filemtime($path);
    }

    /**
     * 格式化路径
     * @param $path
     * @return string
     */
    public static function formatePath($path)
    {
        return rtrim($path, '/') . '/';
    }
}