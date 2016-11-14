<?php

namespace App\FrontModule\Presenters;

use Nette\Application\UI;
use Nette\Utils\Html;

class ContactPresenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @return UI\Form
	 */
	protected function createComponentContactForm()
	{
		$form = new UI\Form();
		$form->addText('name', 'Name')->setRequired();
		$form->addTextArea('message', 'Message')->setRequired();

		$form->addSubmit('send', 'Odeslat');
		$form->onSuccess[] = function (UI\Form $form, $values) {
			$this->flashMessage(Html::el()->addText("Hi $values->name!")->addHtml("<br>Thanks for message!"));
			$this->redirect('this');
		};

		return $form;
	}

}
