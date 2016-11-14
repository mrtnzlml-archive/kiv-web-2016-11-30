<?php

namespace App\FrontModule\Presenters;

use Nette;
use Nette\Application\UI;

class SinglePresenter extends Nette\Application\UI\Presenter
{

	protected function createComponentLoginForm()
	{
		$form = new UI\Form;
		$form->addText('username', 'Username')->setRequired();
		$form->addPassword('password', 'Password')->setRequired();
		$form->addSubmit('send');
		$form->onSuccess[] = function (UI\Form $form, $values) {
			try {
				$this->user->login($values->username, $values->password);
				$this->redirect('this');
			} catch (\Nette\Security\AuthenticationException $exc) {
				$form->addError($exc->getMessage());
			}
		};
		return $form;
	}

	public function handleSignOut()
	{
		//FIXME: possible CSRF
		$this->user->logout();
		$this->redirect('this');
	}

}
