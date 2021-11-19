<?php

namespace MultidocParser\Services;

use Symfony\Component\Finder\Finder;

class InputFileService
{
    /**
     * @param string $path Path in which we get all files to be parsed
     * @param array $exceptionList List of files to skip
     * @return array
     */
    public function getFileListFromPath($path, $exceptionList = array())
    {
        $finder = Finder::create();
        $files = array();
        $filesObj = $finder->files()->name(['*.yml', '*.yaml'])->in($path);

        if (!empty($exceptionList)) {
            $filter = function (\SplFileInfo $file) use ($exceptionList) {
                return !in_array($file->getPathname(), $exceptionList);
            };
            $finder->files()->filter($filter);
        }
        foreach ($filesObj as $file) {
            $files[] = $file;
        }
        return $files;
    }
}