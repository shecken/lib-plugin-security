<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_types=1);

namespace CaT\Security\PluginLogin\ILIAS;

use CaT\Security\PluginLogin\AllowedUsernamesGUI;

class ilAllowedUsernamesGUI implements AllowedUsernamesGUI
{
	/**
	 * @var string
	*/
	protected $form_link;
	/**
	 * @var string
	*/
	protected $save_cmd;
	/**
	 * @var string
	*/
	protected $cancel_cmd;
	/**
	 * @var string
	*/
	protected $post_input;
	/**
	 * @var string
	*/
	protected $autcomplete_link;
	/**
	 * @var \Closure
	*/
	protected $txt;
	/**
	 * @var string[]
	*/
	protected $values;

	public function __construct(
		string $form_link,
		string $save_cmd,
		string $cancel_cmd,
		string $post_input,
		string $autcomplete_link,
		\Closure $txt,
		array $values
	) {
		$this->form_link = $form_link;
		$this->save_cmd = $save_cmd;
		$this->cancel_cmd = $cancel_cmd;
		$this->post_input = $post_input;
		$this->autcomplete_link = $autcomplete_link;
		$this->txt = $txt;
		$this->values = $values;
	}

	public function getHtml(): string
	{
		$form = new \ilPropertyFormGUI();
		$form->setTitle($this->txt("allowed_usernames"));
		$form->setFormAction($this->form_link);

		$ti = new \ilTextInputGUI($this->txt("usernames"), $this->post_input);
		$ti->setInfo($this->txt("usernames_info"));
		$ti->setMulti(true);
		$ti->setDataSource($this->autcomplete_link);
		$form->addItem($ti);

		$form->addCommandButton($this->save_cmd, $this->txt("save"));
		$form->addCommandButton($this->cancel_cmd, $this->txt("cancel"));

		$form->setValuesByArray($this->values);

		return $form->getHtml();
	}

	public function txt(string $code): string
	{
		return call_user_func($this->txt, $code);
	}
}