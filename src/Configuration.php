<?php

declare(strict_types=1);

namespace Shahruslan\PsalmPluginBitrix;

use Exception;
use SimpleXMLElement;

class Configuration
{
    private SimpleXMLElement $configuration;

    /**
     * @throws Exception
     */
    public function __construct(?SimpleXMLElement $configuration)
    {
        if ($configuration === null) {
            throw new Exception('Plugin configuration is empty');
        }

        $this->configuration = $configuration;
    }

    /**
     * @throws Exception
     */
    public function getBitrixPath(): string
    {
        if (!isset($this->configuration->bitrixDir)) {
            throw new Exception('bitrixDir option not specified');
        }

        $dir = realpath((string)$this->configuration->bitrixDir);

        if ($dir === false) {
            throw new Exception('bitrixDir option value is invalid');
        }

        if (!is_dir($dir)) {
            throw new Exception('bitrixDir option value is not a directory');
        }

        return $dir;
    }

    public function getModules(): array
    {
        $modules = [];

        if (!isset($this->configuration->modules) || !isset($this->configuration->modules->module)) {
            return $modules;
        }

        foreach ($this->configuration->modules->module as $module) {
            $modules[] = (string)$module['name'];
        }

        return array_filter(array_unique($modules));
    }

    /**
     * @throws Exception
     */
    public function getCustomOrmAnnotationPath(): ?string
    {
        if (!isset($this->configuration->customOrmAnnotation)) {
            return null;
        }

        $file = realpath((string)$this->configuration->customOrmAnnotation);

        if ($file === false) {
            throw new Exception('customOrmAnnotation option value is invalid');
        }

        if (!is_file($file)) {
            throw new Exception('customOrmAnnotation option value is not a file');
        }

        return $file;
    }
}
