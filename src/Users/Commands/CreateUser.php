<?php

namespace App\Users\Commands;

use App\Users\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUser extends Command
{

	/** @var UserManager @inject */
	public $userManager;

	protected function configure()
	{
		$this->setName('app:create:user');
		$this
			->addArgument('name', InputArgument::REQUIRED, 'What is the name of new user?')
			->addArgument('password', InputArgument::REQUIRED, 'What is the password of newly created user?');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		try {
			$this->userManager->add(
				$input->getArgument('name'),
				$input->getArgument('password')
			);
			$output->writeln('<info>New user has been successfully created.</info>');
		} catch (\App\Users\Exceptions\DuplicateNameException $exc) {
			$output->writeln('<error>This user already exists.</error>');
		}
	}

}
