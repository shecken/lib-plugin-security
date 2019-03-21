<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_type=1);

namespace CaT\Security\PluginLogin;

interface DB
{
	public function addUsername(string $username);
	/**
	 * @return User
	 */
	public function selectUsernames(): array;
	public function checkUsername(string $username): bool;
	public function truncate();
}