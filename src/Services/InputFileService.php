<?php

namespace Multidoc\Services;

use Symfony\Component\Finder\Finder;

class InputFileService
{
    const DEFAULT_EXTENSION = 'yml';
    /**
     * @param string $path Path in which we get all files to be parsed
     * @param array $exceptionList List of files to skip
     * @return array
     */
    public function getFileListFromPath($path, $exceptionList=array())
    {
        $finder = Finder::create();
        $files = array();
        $filesObj = $finder->files()->name('*.'.self::DEFAULT_EXTENSION)->in($path);

        if(!empty($exceptionList)){
            $filter = function (\SplFileInfo $file) use ($exceptionList)
            {
                if (in_array($file->getRealPath(), $exceptionList)) {
                    return false;
                }
            };
            $finder->files()->filter($filter);
        }
        foreach ($filesObj as $file) {
           $files[]=$file;
        }
        return $files;
    }
}