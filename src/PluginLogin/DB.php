<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_types=1);

namespace CaT\Security\PluginLogin;

interface DB
{
	public function addUsername(string $username, string $plugin);
	/**
	 * @return AuthObject
	 */
	public function selectUsernames(string $plugin): array;
	public function checkUsername(string $username, string $plugin): bool;
	public function loginEnabled(string $plugin): bool;
	public function deleteFor(string $plugin);
}