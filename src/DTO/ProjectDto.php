<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property string $name
 * @property string $description
 * @property string $version
 * @property int $buildDate
 * @property string $logo
 * @property string $definitionFile
 * @property CategoryDto[] $categories
 * @property EnvironmentDto[] $environments
 */
class ProjectDto extends DataTransferObject
{
    protected $casts = [
        'environments' => EnvironmentDto::class,
        'categories' => CategoryDto::class,
        'version'=>'string'
    ];

    protected $hidden = [
        'categories',
        'definitionFile'
    ];

    public function __construct($arguments)
    {
        parent::__construct($arguments);
    }

    public function jsonSerialize()
    {
        $return = [
            'name'=>$this->name,
            'version'=>$this->version,
            'description'=>$this->description,
            'buildDate'=>$this->buildDate,
        ];
        if ($this->environments) {
            $return['environments'] = $this->environments;
        }
        if ($this->logo) {
            $return['logo'] = $this->logo;
        }
        return $return;
    }
}