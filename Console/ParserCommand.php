<?php

namespace Multidoc\Console;

use Multidoc\Services\MultidocService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;


class ParserCommand extends Command
{
    /**
     * @var MultidocService
     */
    private $multidocSrvice;

    public function __construct(MultidocService $multidocService)
    {
        parent::__construct('parser');
        $this->multidocSrvice = $multidocService;
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
        $this->multidocSrvice->generate($inputFolder, $outputFolder);
    }
}