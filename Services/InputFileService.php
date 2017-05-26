<?php

namespace Multidoc\Services;

use Symfony\Component\Finder\Finder;

class InputFileService
{
    const DEFAULT_EXTENSION = 'yaml';
    /**
     * @param string $path Path in which we get all files to be parsed
     * @param string $extension The extension of the files we will be parsing
     * @return array
     */
    public function getFileListFromPath($path, $extension=self::DEFAULT_EXTENSION)
    {
        $finder = Finder::create();
        $files = array();
        $filesObj = $finder->files()->name('*.'.$extension)->in($path);
        foreach ($filesObj as $file) {
           $files[]=$file;
        }
        return $files;
    }
}