<?php

namespace MultidocParser\Services;

use MultidocParser\DTO\ProjectDto;
use MultidocParser\DTO\RouteDto;
use MultidocParser\Exceptions\CategoriesNotFoundException;
use MultidocParser\Exceptions\DefinitionFileException;
use MultidocParser\Exceptions\MultipleProjectsException;
use MultidocParser\Exceptions\NoCategoryRouteException;
use MultidocParser\Exceptions\ProjectNotDefinedException;
use MultidocParser\Exceptions\RoutesNotDefinedException;
use MultidocParser\Exceptions\UndefinedTemplateException;
use MultidocParser\Exceptions\UndefinedVariableException;
use MultidocParser\Exceptions\UnusedVariableException;
use MultidocParser\Normalizers\CategoryNormalizer;
use MultidocParser\Normalizers\DataNormalizer;
use SplFileObject;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class FileContentParserService
{
    public const ROUTE_SINGULAR_KEY = 'route';
    public const STATUS_PLURAL_LIST = 'status_codes';
    public const ROUTE_PLURAL_KEY = 'route_list';
    public const CATEGORY_PLURAL_KEY = 'categories';
    public const TAGS_KEY = 'tags';
    public const ROUTE_METHOD_POST = 'POST';
    public const FILE_PATH_KEY = 'definitionFile';
    public const PARAMETER_TYPE_FILE = 'file';
    public const TEMPLATES_KEY = 'templates';
    public const PROJECT_KEY = 'project';
    public const VARIABLES_KEY = 'variables';
    // Protected because it composes routed in the ui
    public const ENVIRONMENT_KEY = 'environment';

    public const variableStart = "{{";
    public const variableEnd = "}}";

    public const variableFormat = self::variableStart."%s".self::variableEnd;

    private DataNormalizer $dataNormalizer;
    private CategoryNormalizer $categoryNormalizer;
    private ValidationService $validationParser;

    public function __construct(ValidationService $validationParser, DataNormalizer $dataNormalizer, CategoryNormalizer $categoryNormalizer)
    {
        $this->dataNormalizer = $dataNormalizer;
        $this->categoryNormalizer = $categoryNormalizer;
        $this->validationParser = $validationParser;
    }

    /**
     * Array with paths pointing to the input configuration file list
     * @param SplFileObject[] $fileList
     * @return ProjectDto
     * @throws CategoriesNotFoundException
     * @throws MultipleProjectsException
     * @throws ProjectNotDefinedException
     * @throws RoutesNotDefinedException
     * @throws UndefinedTemplateException
     * @throws UndefinedVariableException
     * @throws UnusedVariableException
     * @throws NoCategoryRouteException
     */
    public function getProjectFromFileList(array $fileList): ProjectDto
    {
        $data = $this->readFiles($fileList);
        $this->validationParser->validateParsedData($data);

        $data[self::ROUTE_PLURAL_KEY] = $this->dataNormalizer->fillInTemplates($data['templates'], $data[self::ROUTE_PLURAL_KEY]);
        $this->validationParser->validateVariables($data);
        $data[self::ROUTE_PLURAL_KEY] = $this->dataNormalizer->formatTagsAndStatusAndHeaders($data[self::ROUTE_PLURAL_KEY]);
        $data[self::PROJECT_KEY] = $this->dataNormalizer->normalizeProjectData($data[self::PROJECT_KEY]);
        $data[self::CATEGORY_PLURAL_KEY] = $this->dataNormalizer->normalizeCategoryList($data[self::CATEGORY_PLURAL_KEY]);

        $data[self::PROJECT_KEY][self::CATEGORY_PLURAL_KEY] = $data[self::CATEGORY_PLURAL_KEY];
        unset($data[self::CATEGORY_PLURAL_KEY]); // Free up some memory

        $generatedEntities[self::PROJECT_KEY] = new ProjectDto($data[self::PROJECT_KEY]);
        $generatedEntities[self::ROUTE_PLURAL_KEY] = RouteDto::hydrate($data[self::ROUTE_PLURAL_KEY]);

        return $this->categoryNormalizer->linkObjects(
            $generatedEntities[self::PROJECT_KEY],
            $generatedEntities[self::ROUTE_PLURAL_KEY]
        );
    }

    /**
     * @param $fileList
     * @return array[]
     * @throws ParseException|MultipleProjectsException
     */
    private function readFiles($fileList)
    {
        $data = array(
            'templates' => []
        );
        $initialProjectFile = null;
        $projectLoaded = false;
        foreach ($fileList as $file) {
            $definitionArray = Yaml::parse(file_get_contents($file));
            //If the current file contains the project definition
            if (array_key_exists(self::PROJECT_KEY, $definitionArray)) {
                if ($projectLoaded) {
                    throw new MultipleProjectsException([$file, $initialProjectFile]);
                }
                $initialProjectFile = $file;
                $definitionArray[self::PROJECT_KEY][self::FILE_PATH_KEY] = $file->getPath();
                $projectLoaded = true;
            }
            //If the current file contains a route definition
            if (array_key_exists(self::ROUTE_SINGULAR_KEY, $definitionArray)) {
                $definitionArray[self::ROUTE_PLURAL_KEY] = array($definitionArray['route']);
                $definitionArray[self::ROUTE_SINGULAR_KEY][self::FILE_PATH_KEY] = $file->getPath();
                unset($definitionArray[self::ROUTE_SINGULAR_KEY]);
            }
            //We inject the file path
            if (array_key_exists(self::ROUTE_PLURAL_KEY, $definitionArray)) {
                $definitionArray = $this->dataNormalizer->hydrateFilesToRouteDefinitionList($file, $definitionArray);
            }
            //If the current file contains a list of routes we unify
            $data = array_merge_recursive($data, $definitionArray);
        }

        return $data;
    }
}