<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_types=1);

namespace CaT\Security\PluginLogin\ILIAS;

use CaT\Security\PluginLogin\User;

class ilUser implements User
{
	/**
	 * @var string
	 */
	 protected $username;

	 public function __construct(string $username)
	 {
	 	$this->username = $username;
	 }

	 public function getUsername(): string
	 {
	 	return $this->username;
	 }
}