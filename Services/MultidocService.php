<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 18-May-17
 * Time: 5:28 PM
 */

namespace Multidoc\Services;

use Symfony\Component\Filesystem\Exception\IOException;

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
        try{
            $this->outputService->exportLogo($project, $inputFolder, $outputFolder);
        } catch(IOException $e){
            echo "Logo file is misspelled or does not exist";
        }
        try{
            $this->outputService->exportExampleFiles($project->getCategoryList(), $inputFolder, $outputFolder);
        } catch (IOException $e) {
            echo "File does not exist";
        }
    }
}