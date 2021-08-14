<?php

namespace Vuongdq\VLAdminTool\Generators;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Utils\FileUtil;


/**
 * Class SeederGenerator.
 */
class LanguageGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $langFolderPath;

    /**
     * ModelGenerator constructor.
     *
     * @param CommandData $commandData
     */
    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->langFolderPath = $commandData->config->pathLang;
    }

    private function generateLocaleFileByLanguage(string $language)
    {
        $locales = [
            'singular' => Str::title(str_replace('_', ' ', $this->commandData->config->mSingular)),
            'plural'   => Str::title(str_replace('_', ' ', $this->commandData->config->mPlural)),
            'fields'   => [],
        ];

        foreach ($this->commandData->fields as $field) {
            $locales['fields'][$field->name] = Str::title(str_replace('_', ' ', $field->name));
        }

        $path = config('vl_admin_tool.path.lang', base_path('resources/lang/')) . $language . '/models/';

        $fileName = $this->commandData->config->mCamel.'.php';

        $content = "<?php\n\nreturn ".var_export($locales, true).';'.\PHP_EOL;

        FileUtil::createFile($path, $fileName, $content);
        $this->commandData->commandComment("\nLanguage {$language}: {$fileName}");
    }

    public function generate()
    {
        $this->commandData->commandComment('\nAdding Locale Files...');
        $languages = ['en'];
        foreach ($languages as $language) {
            $this->generateLocaleFileByLanguage($language);
        }

        $this->commandData->commandComment("\nAdding Locale Files Successfully!");
    }

    public function rollback()
    {
        $this->commandData->commandComment('Locale File Removing...');
        $languages = ['en'];
        foreach ($languages as $language) {
            $this->removeLocaleFileByLanguage($language);
        }
        $this->commandData->commandComment('\nRemoving Locale File successfully!');
    }

    private function removeLocaleFileByLanguage(string $language)
    {
        $path = config('vl_admin_tool.path.lang', base_path('resources/lang/')) . $language . '/models/';

        $fileName = $this->commandData->config->mCamel.'.php';

        if (file_exists($path.$fileName)) {
            FileUtil::deleteFile($path, $fileName);
        }
    }
}
