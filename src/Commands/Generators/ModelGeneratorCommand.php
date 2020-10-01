<?php

namespace Vuongdq\VLAdminTool\Commands\Generators;

use Vuongdq\VLAdminTool\Commands\BaseCommand;
use Vuongdq\VLAdminTool\Common\CommandData;

class ModelGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vlat.generate:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Model from table or file';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        if ($this->checkIsThereAnyDataToGenerate()) {
            $this->generateCommonItems();

            $this->generateScaffoldItems();

            $this->performPostActionsWithMigration();
        } else {
            $this->commandData->commandInfo('There are not enough input fields for scaffold generation.');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'Singular Models name'],
        ];
    }

    /**
     * Check if there is anything to generate.
     *
     * @return bool
     */
    protected function checkIsThereAnyDataToGenerate()
    {
        if (count($this->commandData->fields) > 1) {
            return true;
        }
    }
}
