<?php

namespace App\Command;

use Symfony\Component\Uid\Uuid;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:createuuids',
    description: 'Add a short description for your command',
)]
class CreateuuidsCommand extends Command
{
    public function __construct(private ArticleRepository $ar, private EntityManagerInterface $manager, private SluggerInterface $slugger)
    {
        parent::__construct();
        
    }


    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        foreach($this->ar->findAll() as $a) {
            $output->writeln($a->getNom());
            // $a->setUuid(Uuid::v4()); //
            $a->setSlug($this->slugger->slug(substr(trim($a->getNom()), 0, 30)) . '-' . uniqid());
            $output->writeln($a->getNom());
        }
        $this->manager->flush();
        
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
