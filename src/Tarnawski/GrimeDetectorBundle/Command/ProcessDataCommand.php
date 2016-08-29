<?php

namespace Tarnawski\GrimeDetectorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tarnawski\GrimeDetector\DictionaryStore\JsonDictionaryStore;
use Tarnawski\GrimeDetector\Processor\DataProcessor;

class ProcessDataCommand extends ContainerAwareCommand
{
    const GRIM = 'grim';
    const HAM = 'ham';

    protected function configure()
    {
        $this->setName('data:process');
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to the training data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var DataProcessor $processor */
        $processor = $this->getContainer()->get('tarnawski.grime_detector.data_processor');
        $trainingPath = $input->getArgument('path');

        $processor->loadTrainingData($trainingPath);
        $dictionary = $processor->process();

        /** @var JsonDictionaryStore $jsonDictionaryStore */
        $jsonDictionaryStore = $this->getContainer()->get('tarnawski.grime_detector.json_dictionary_store');

        $jsonDictionaryStore->write($dictionary);

        $output->writeln("Finish");
    }

}