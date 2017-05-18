<?php

namespace Multidoc\Services;

use Symfony\Component\Finder\Finder;

class InputFileService
{
    const DEFAULT_EXTENSION = 'yaml';

    /**
     * @var Finder
     */
    private $finder;

    /**
     * FileService constructor.
     * @param Finder $finder
     */
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param string $path Path in which we get all files to be parsed
     * @param string $extension The extension of the files we will be parsing
     * @return array
     */
    public function getFileListFromPath($path, $extension=self::DEFAULT_EXTENSION)
    {
        $files = array();
        $this->finder->files()->in(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$path)->name('*.'.$extension);
        foreach ($this->finder as $file) {
           $files[]=$file;
        }
        return $files;
    }
}