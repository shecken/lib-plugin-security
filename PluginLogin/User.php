<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_type=1);

namespace CaT\Security\PluginLogin;

class User
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