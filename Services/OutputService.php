<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/26/2017
 * Time: 9:00 PM
 */

namespace Multidoc\Services;

use Multidoc\Models\Project;
use Multidoc\Renderers\CategoryRenderer;
use Multidoc\Renderers\ProjectRenderer;
use Symfony\Component\Filesystem\Filesystem;

class OutputService
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
        $this->outputDirectory = $this->outputDirectory.$outputPath;
        if (!$this->fileService->exists($this->outputDirectory)) {
            $this->fileService->mkdir($this->outputDirectory);
        }

    }

    /**
     * @param Project $project
     */
    public function exportProjectToOutputFolder(Project $project)
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
}