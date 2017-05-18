<?php

namespace Multidoc\Console;

use Multidoc\Services\FileContentParserService;
use Multidoc\Services\InputFileService;
use Multidoc\Services\OutputFileService;
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
     * @var InputFileService
     */
    private $fileService;

    /**
     * @var FileContentParserService
     */
    private $parserService;

    /**
     * @var OutputFileService
     */
    private $outputService;

    public function __construct(InputFileService $fileService, FileContentParserService $parserService, OutputFileService $outputService)
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

        $fileList = $this->fileService->getFileListFromPath($inputFolder);
        $project = $this->parserService->getProjectFromFileList($fileList);
        $this->outputService->prepareOutputFolder($outputFolder);
        $this->outputService->exportProjectEntityToOutputFolder($project);
    }
}