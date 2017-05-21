<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 18-May-17
 * Time: 5:28 PM
 */

namespace Multidoc\Services;

class MultidocService
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

    public function generate($inputFolder, $outputFolder)
    {
        $fileList = $this->fileService->getFileListFromPath($inputFolder);
        $project = $this->parserService->getProjectFromFileList($fileList);
        $this->outputService->prepareOutputFolder($outputFolder);
        $this->outputService->exportProjectEntityToOutputFolder($project);
    }
}