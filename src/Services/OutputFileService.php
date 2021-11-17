<?php
namespace Multidoc\Services;

use Multidoc\DTO\CategoryDto;
use Multidoc\DTO\ParameterDto;
use Multidoc\DTO\ProjectDto;
use Multidoc\DTO\RouteDto;
use Multidoc\Renderers\CategoryRenderer;
use Symfony\Component\Filesystem\Filesystem;

class OutputFileService
{
    const DEFAULT_OUTPUT_PATH = 'output';

    /**
     * @var Filesystem
     */
    private $fileService;

    /**
     * @var CategoryRenderer
     */
    private $categoryRenderer;

    private $outputDirectory = __DIR__.'\..\\';

    private $projectFileName = 'project.json';

    private $categoryListFileName = 'categories.json';


    public function __construct(
        Filesystem $fileService,
        CategoryRenderer $categoryRenderer
    )
    {
        $this->fileService = $fileService;
        $this->categoryRenderer = $categoryRenderer;
    }

    public function prepareOutputFolder($outputPath)
    {
        if(empty($outputPath)) {
            $outputPath = self::DEFAULT_OUTPUT_PATH;
        }
        $this->outputDirectory = $outputPath;
        if (!$this->fileService->exists($this->outputDirectory)) {
            $this->fileService->mkdir($this->outputDirectory);
        }
    }

    /**
     * @param ProjectDto $project
     */
    public function exportProjectEntityToOutputFolder(ProjectDto $project)
    {
        $this->removeCurrentFilesInOutput();
        $this->fileService->dumpFile(
            $this->outputDirectory.DIRECTORY_SEPARATOR.$this->projectFileName,
            json_encode($project, JSON_PRETTY_PRINT)
        );

        $this->fileService->dumpFile(
            $this->outputDirectory.DIRECTORY_SEPARATOR.$this->categoryListFileName,
            json_encode(
                $this->categoryRenderer->renderList($project->categories), JSON_PRETTY_PRINT)
        );
    }

    private function removeCurrentFilesInOutput()
    {
        $this->fileService->remove(array(
            $this->outputDirectory.DIRECTORY_SEPARATOR,
            $this->outputDirectory.DIRECTORY_SEPARATOR
        ));
    }

    public function exportLogo(ProjectDto $project, $outputFolder)
    {
        if ($project->logo) {
            $this->fileService->copy(
                $project->definitionFile.DIRECTORY_SEPARATOR.$project->logo,
                $outputFolder.DIRECTORY_SEPARATOR.$project->logo,
                true
            );
        }
    }

    /**
     * @param CategoryDto[] $categoryList
     * @param string $outputFolder
     */
    public function exportExampleFiles($categoryList, $outputFolder)
    {
        foreach($categoryList as $category) {
            if ($category->routeList) {
                foreach ($category->routeList as $route) {
                    $this->moveExampleFilesFromRoute($route, $outputFolder);
                }
            }
            if ($category->categories) {
                $this->exportExampleFiles($category->categories, $outputFolder);
            }
        }
    }

    /**
     * @param RouteDto $route
     * @param $outputFolder
     */
    private function moveExampleFilesFromRoute(RouteDto $route, $outputFolder)
    {
        if($route->request->method == FileContentParserService::ROUTE_METHOD_POST){
            /**
             * @var $paramList ParameterDto[]
             */
            $paramList = $route->request->params;
            // Some POST endpoints do not have body params
            if (empty($paramList)) {
                return;
            }
            foreach($paramList as $parameter) {
                if($parameter->data_type == FileContentParserService::PARAMETER_TYPE_FILE){
                    $this->fileService->copy(
                        $route->inputPath.DIRECTORY_SEPARATOR.$parameter->example,
                        $outputFolder.DIRECTORY_SEPARATOR.$parameter->example,
                        true
                    );
                }
            }
        }
    }
}