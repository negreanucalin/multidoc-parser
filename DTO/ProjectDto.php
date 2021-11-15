<?php

namespace Multidoc\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $name string
 * @property $description string
 * @property $version string
 * @property $buildDate int
 * @property $logo string
 * @property CategoryDto[] $categoryList
 * @property EnvironmentDto[] $environments
 */
class ProjectDto extends DataTransferObject
{
    protected $casts = [
        'environments:map' => EnvironmentDto::class,
        'categoryList' => CategoryDto::class,
        'version'=>'string'
    ];

    protected $hidden = [
        'categoryList',
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