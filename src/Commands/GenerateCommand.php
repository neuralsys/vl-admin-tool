<?php

namespace Vuongdq\VLAdminTool\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Vuongdq\VLAdminTool\Common\CommandData;
use function Couchbase\defaultDecoder;

class GenerateCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vlat:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full CRUD views for given model';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD);
    }

    /**
     * Execute the command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        $exitCode = parent::handle();
        if ($exitCode) return $exitCode;

        if ($this->checkIsThereAnyDataToGenerate()) {
            try {
                $this->generateCommonItems();

                $this->generateScaffoldItems();

                $this->performPostActionsWithMigration();
                return 0;
            } catch (\Exception $e) {
                throw $e;
                throw new \Exception($e->getMessage()."\n".$e->getFile()."\n".$e->getLine());
            }
        } else {
            $this->commandData->commandInfo('There are not enough input fields for generation.');
            throw new \Exception('There are not enough input fields for generation.', 1);
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
            ['model', InputArgument::REQUIRED, 'Singular Model Name'],
        ];
    }

    /**
     * Check if there is anything to generate.
     *
     * @return bool
     */
    protected function checkIsThereAnyDataToGenerate()
    {
        if (isset($this->commandData->fields) && count($this->commandData->fields) > 1) {
            return true;
        }
    }
}
