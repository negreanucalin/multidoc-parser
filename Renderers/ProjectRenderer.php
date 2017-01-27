<?php

namespace Multidoc\Renderers;

class ProjectRenderer
{
    /**
     * ProjectRenderer constructor.
     * @param EnvironmentRenderer $envRenderer
     */
    public function __construct(EnvironmentRenderer $envRenderer)
    {
        $this->environmentRenderer = $envRenderer;
    }

    /**
     * @param \Multidoc\Models\Project $project
     * @return array
     */
    public function renderProject(\Multidoc\Models\Project $project)
    {
        return array(
            'name'=>$project->getName(),
            'description'=>$project->getDescription(),
            'version'=>$project->getVersion(),
            'buildDate'=>(int)$project->getBuildTime()->format('U'),
            'environments'=>$this->environmentRenderer->renderEnvironmentList($project->getEnvironmentList()),
        );
    }
}