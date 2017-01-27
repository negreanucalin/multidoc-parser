<?php

namespace Multidoc\Console;

use Multidoc\Services\FileService;
use Multidoc\Services\OutputService;
use Multidoc\Services\ParserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ParserCommand extends Command
{
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var ParserService
     */
    private $parserService;

    /**
     * @var OutputService
     */
    private $outputService;

    public function __construct(FileService $fileService, ParserService $parserService, OutputService $outputService)
    {
        parent::__construct('parser');
        $this->fileService = $fileService;
        $this->parserService = $parserService;
        $this->outputService = $outputService;
    }

    protected function configure()
    {
        $this
            ->setName('parse:interactive')
            ->setDescription('Parses and generates api documentation')
            ->addArgument('output', InputArgument::OPTIONAL, 'In which folder do you want the otput?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileList = $this->fileService->getAllFiles('input');
        $project = $this->parserService->loadApiInput($fileList);
        $this->outputService->prepareOutputFolder($input->getArgument('output'));
        $this->outputService->exportProjectToOutputFolder($project);
    }
}