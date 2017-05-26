<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/26/2017
 * Time: 9:00 PM
 */

namespace Multidoc\Services;

use Multidoc\Factories\ParameterFactory;
use Multidoc\Factories\RouteFactory;
use Multidoc\Models\Category;
use Multidoc\Models\Project;
use Multidoc\Models\Route;
use Multidoc\Renderers\CategoryRenderer;
use Multidoc\Renderers\ProjectRenderer;
use Symfony\Component\Filesystem\Filesystem;

class OutputFileService
{
    const DEFAULT_OUTPUT_PATH = 'output';

    /**
     * @var Filesystem
     */
    private $fileService;

    /**
     * @var ProjectRenderer
     */
    private $projectRenderer;

    /**
     * @var CategoryRenderer
     */
    private $categoryRenderer;

    private $outputDirectory = __DIR__.'\..\\';

    private $projectFileName = 'project.json';

    private $categoryListFileName = 'categories.json';


    public function __construct(
        Filesystem $fileService,
        ProjectRenderer $projectRenderer,
        CategoryRenderer $categoryRenderer
    )
    {
        $this->fileService = $fileService;
        $this->projectRenderer = $projectRenderer;
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
     * @param Project $project
     */
    public function exportProjectEntityToOutputFolder(Project $project)
    {
        $this->removeCurrentFilesInOutput();
        $this->fileService->dumpFile(
            $this->outputDirectory.DIRECTORY_SEPARATOR.$this->projectFileName,
            json_encode($this->projectRenderer->renderProject($project))
        );
        $this->fileService->dumpFile(
            $this->outputDirectory.DIRECTORY_SEPARATOR.$this->categoryListFileName,
            json_encode($this->categoryRenderer->renderList($project->getCategoryList()))
        );
    }

    private function removeCurrentFilesInOutput()
    {
        $this->fileService->remove(array(
            $this->outputDirectory.DIRECTORY_SEPARATOR,
            $this->outputDirectory.DIRECTORY_SEPARATOR
        ));
    }

    public function exportLogo(Project $project, $inputFolder, $outputFolder)
    {
        if($project->getLogo()) {
            $this->fileService->copy(
                $inputFolder.DIRECTORY_SEPARATOR.$project->getLogo(),
                $outputFolder.DIRECTORY_SEPARATOR.$project->getLogo(),
                true
            );
        }
    }

    /**
     * @param Category[] $categoryList
     * @param string $inputFolder
     * @param string $outputFolder
     */
    public function exportExampleFiles($categoryList, $inputFolder, $outputFolder)
    {
        foreach($categoryList as $category) {
            if ($category->getRouteList()) {
                foreach ($category->getRouteList() as $route) {
                    $this->moveExampleFilesFromRoute($route, $inputFolder, $outputFolder);
                }
            }
            if ($category->getCategoryList()) {
                $this->exportExampleFiles($category->getCategoryList(), $inputFolder, $outputFolder);
            } else {
                return null;
            }
        }
    }

    /**
     * @param Route $route
     * @param $inputFolder
     * @param $outputFolder
     */
    private function moveExampleFilesFromRoute(Route $route, $inputFolder, $outputFolder)
    {
        if($route->getRequest()->getMethod() == RouteFactory::ROUTE_METHOD_POST){
            $paramList = $route->getRequest()->getParameterList();
            foreach($paramList as $parameter) {
                if($parameter->getDataType() == ParameterFactory::PARAMETER_TYPE_FILE){
                    $this->fileService->copy(
                        $inputFolder.DIRECTORY_SEPARATOR.$parameter->getExample(),
                        $outputFolder.DIRECTORY_SEPARATOR.$parameter->getExample(),
                        true
                    );
                }
            }
        }
    }
}