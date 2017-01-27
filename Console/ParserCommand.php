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
use Symfony\Component\Console\Question\Question;


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
            ->setDescription('Parses and generates api documentation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $inputQuestion = new Question('Please give the input folder (default:input)?', 'input');
        $inputFolder = $helper->ask($input, $output, $inputQuestion);
        
        $question = new Question('In which folder do you want the output (default:output)?', 'output');
        $outputFolder = $helper->ask($input, $output, $question);

        $fileList = $this->fileService->getAllFiles($inputFolder);
        $project = $this->parserService->loadApiInput($fileList);
        $this->outputService->prepareOutputFolder($outputFolder);
        $this->outputService->exportProjectToOutputFolder($project);
    }
}