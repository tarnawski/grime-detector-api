<?php

namespace Tarnawski\GrimeDetectorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
        $path = $input->getArgument('path');

        $data = $processor->read($path);

        $processor->process($data);

        $output->writeln("Finish");
    }
}