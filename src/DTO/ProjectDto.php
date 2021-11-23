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
 * @property VariableDto[] $variables
 */
class ProjectDto extends DataTransferObject
{
    protected $casts = [
        'categories' => CategoryDto::class,
        'version' => 'string',
        'variables*' => VariableDto::class
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
            'name' => $this->name,
            'version' => $this->version,
            'description' => $this->description,
            'buildDate' => $this->buildDate,
        ];
        if ($this->variables) {
            $return['variables'] = $this->variables;
        }
        if ($this->logo) {
            $return['logo'] = $this->logo;
        }
        return $return;
    }
}