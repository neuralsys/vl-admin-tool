<?php

namespace Vuongdq\VLAdminTool\Utils;

use File;

class FileUtil
{
    public static function createFile($path, $fileName, $contents)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $path = $path . $fileName;

        file_put_contents($path, $contents);
    }

    public static function createDirectoryIfNotExist($path, $replace = false)
    {
        if (file_exists($path) && $replace) {
            rmdir($path);
        }

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }

    public static function copyFile($sourceDir, $fileName, $destinationDir, $force = false)
    {
        $filePath = $destinationDir . "/" . $fileName;

        if (file_exists($filePath) && !$force) {
            return;
        }

        copy($sourceDir . "/" . $fileName, $filePath);
    }

    public static function deleteFile($path, $fileName)
    {
        if (file_exists($path . $fileName)) {
            return unlink($path . $fileName);
        }

        return false;
    }

    public static function copyDirectory($sourceDir, $destinationDir, $force = false)
    {
        if (file_exists($destinationDir) && !$force) {
            return;
        }
        File::makeDirectory($destinationDir, 493, true, true);
        File::copyDirectory($sourceDir, $destinationDir);
    }
}
