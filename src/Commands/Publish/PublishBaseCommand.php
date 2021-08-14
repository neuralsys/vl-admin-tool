<?php

namespace Vuongdq\VLAdminTool\Commands\Publish;

use Vuongdq\VLAdminTool\Commands\BaseCommand;

class PublishBaseCommand extends BaseCommand
{
    public function handle()
    {
        return 0;
    }

    public function publishFile($sourceFile, $destinationFile, $fileName)
    {
        if (file_exists($destinationFile) && !$this->confirmOverwrite($destinationFile)) {
            return;
        }

        copy($sourceFile, $destinationFile);

        $this->comment($fileName.' published');
        $this->info($destinationFile);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}
