<?php

namespace Shahruslan\PsalmPluginBitrix;

use Bitrix\Main\Loader;
use SimpleXMLElement;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;

class Plugin implements PluginEntryPointInterface
{
    public function __invoke(RegistrationInterface $registration, ?SimpleXMLElement $config = null): void
    {
        $configuration = new Configuration($config);

        $path = $configuration->getBitrixPath();
        $modules = $configuration->getModules();
        $customAnnotationFile = $configuration->getCustomOrmAnnotationPath();


        foreach ($this->getPluginStabFiles() as $file) {
            $registration->addStubFile($file);
        }

        $registration->addStubFile("$path/modules/main/meta/orm.php");

        foreach ($this->getModuleStabFiles($modules, $path) as $file) {
            $registration->addStubFile($file);
        }

        if ($customAnnotationFile !== null) {
            $registration->addStubFile($customAnnotationFile);
        }
    }

    /** @return list<string> */
    private function getPluginStabFiles(): array
    {
        return glob(__DIR__ . '/stubs/*.phpstub') ?: [];
    }


    private function getModuleStabFiles(array $modules, string $path): array
    {
        $result = [];

        if (count($modules) === 0) {
            return $result;
        }

        $before = get_included_files();

        foreach ($modules as $module) {
            Loader::includeModule($module);
            $result[] = "$path/modules/$module/meta/orm.php";
        }

        $after = get_included_files();

        $included = array_diff($after, $before);
        $result = array_merge($result, $included);

        foreach (CustomLoader::getClasses() as $class) {
            $result[] = "$path/modules/{$class['module']}/{$class['file']}";
        }

        $result = array_unique($result);
        return $result;
    }
}
