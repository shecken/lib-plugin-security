<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_type=1);

namespace CaT\Security\PluginLogin;

interface DB
{
	/**
	 * @inheritdoc
	 */
	public function addUsername(string $username)
	{

	}

	/**
	 * @inheritdoc
	 */
	public function selectUsernames(): array
	{

	}

	/**
	 * @inheritdoc
	 */
	public function checkUsername(string $username): bool
	{

	}

	/**
	 * @inheritdoc
	 */
	public function truncate()
	{

	}

	public function createTable()
	{

	}

	public function addPrimaryKey()
	{

	}
}