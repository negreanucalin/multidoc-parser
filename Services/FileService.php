<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/25/2017
 * Time: 9:18 AM
 */

namespace Multidoc\Services;


use Symfony\Component\Finder\Finder;

class FileService
{
    /**
     * @var Finder
     */
    private $finder;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function getAllFiles($path)
    {
        $files = array();
        $this->finder->files()->in(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$path);
        foreach ($this->finder as $file) {
           $files[]=$file;
        }
        return $files;
    }
}