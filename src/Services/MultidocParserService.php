<?php

namespace MultidocParser\Services;

use MultidocParser\DTO\ProjectDto;
use MultidocParser\Exceptions\CategoriesNotFoundException;
use MultidocParser\Exceptions\ProjectNotDefinedException;
use MultidocParser\Exceptions\RoutesNotDefinedException;
use MultidocParser\Exceptions\UndefinedTemplateException;
use Symfony\Component\Filesystem\Exception\IOException;

class MultidocParserService
{
    /**
     * @var InputFileService
     */
    private $fileService;

    /**
     * @var FileContentParserService
     */
    private $parserService;

    /**
     * @var OutputFileService
     */
    private $outputService;

    public function __construct(InputFileService $fileService, FileContentParserService $parserService, OutputFileService $outputService)
    {
        $this->fileService = $fileService;
        $this->parserService = $parserService;
        $this->outputService = $outputService;
    }

    /**
     * @param $inputFolder
     * @param $outputFolder
     * @param array $excludeList
     * @return ProjectDto
     * @throws CategoriesNotFoundException
     * @throws ProjectNotDefinedException
     * @throws RoutesNotDefinedException
     * @throws UndefinedTemplateException
     */
    public function generate($inputFolder, $outputFolder, $excludeList = array())
    {
        $fileList = $this->fileService->getFileListFromPath($inputFolder, $excludeList);
        $project = $this->parserService->getProjectFromFileList($fileList);
        $this->outputService->prepareOutputFolder($outputFolder);
        $this->outputService->exportProjectEntityToOutputFolder($project);
        try {
            $this->outputService->exportLogo($project, $outputFolder);
        } catch (IOException $e) {
            echo "\nLogo file is misspelled or does not exist";
        }
        try {
            $this->outputService->exportExampleFiles($project->categories, $outputFolder);
        } catch (IOException $e) {
            echo "\nFile does not exist";
        }
        return $project;
    }
}