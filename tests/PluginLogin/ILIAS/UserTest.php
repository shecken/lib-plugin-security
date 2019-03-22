<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_types=1);

namespace CaT\Security\PluginLogin\ILIAS;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
	public function test_create_instance()
	{
		$username = "gluck";
		$user = new ilUser($username);

		$this->assertInstanceOf(ilUser::class, $user);
		$this->assertEquals($username, $user->getUsername());
	}
}