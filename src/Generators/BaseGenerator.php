<?php

namespace Vuongdq\VLAdminTool\Generators;

use Vuongdq\VLAdminTool\Utils\FileUtil;

class BaseGenerator
{
    public function rollbackFile($path, $fileName)
    {
        if (file_exists($path.$fileName)) {
            return FileUtil::deleteFile($path, $fileName);
        }

        return false;
    }

    public function rollback() {

    }
}
