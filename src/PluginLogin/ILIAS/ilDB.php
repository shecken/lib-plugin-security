<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_types=1);

namespace CaT\Security\PluginLogin\ILIAS;

use CaT\Security\PluginLogin\DB;

class ilDB implements DB
{
	const TABLE_NAME = "allowed_usernames";

	/**
	 * @var \ilDBInterface
	 */
	protected $db

	public function __construct(\ilDBInterface $db)
	{
		$this->db = $db;
	}

	/**
	 * @inheritdoc
	 */
	public function addUsername(string $username, string $plugin)
	{
		$values = [
			"username" => [
				"text",
				$username
			],
			"plugin" => [
				"text",
				$plugin
			]
		];

		$this->db->insert(self::TABLE_NAME, $values);
	}

	/**
	 * @inheritdoc
	 */
	public function selectUsernames(string $plugin): array
	{
		$table = self::TABLE_NAME;
		$plugin = $this->db->quote($plugin, "text");
		$query = <<<EOT
SELECT username
FROM $table
WHERE plugin = $plugin
EOT;

		$res = $this->db->query($query);
		$ret = [];

		while($row = $this->db->fetchAssoc($res)) {
			$ret[] = new ilUser($row["username"]);
		}

		return $ret;
	}

	/**
	 * @inheritdoc
	 */
	public function checkUsername(string $username, string $plugin): bool
	{
		$table = self::TABLE_NAME;
		$plugin = $this->db->quote($plugin, "text");
		$username = $this->db->quote($username, "text");
		$query = <<<EOT
SELECT username
FROM $table
WHERE plugin = $plugin
AND username = $username
EOT;

		$res = $this->db->query($query);
		return $this->db->numRows($res) == 1;
	}

	/**
	 * @inheritdoc
	 */
	public function loginEnabled(string $plugin): bool
	{
		$table = self::TABLE_NAME;
		$plugin = $this->db->quote($plugin, "text");
		$query = <<<EOT
SELECT count(username) AS cnt
FROM $table
WHERE plugin = $plugin
EOT;

		$res = $this->db->query($query);
		$row = $this->db->fetchAssoc($res);
		return $row["cnt"] > 0;
	}

	/**
	 * @inheritdoc
	 */
	public function deleteFor(string $plugin)
	{
		$table = self::TABLE_NAME;
		$plugin = $this->db->quote($plugin, "text");
$query = <<<EOT
DELETE FROM $table
WHERE plugin = $plugin
EOT;

		$this->db->manipulate($query);
	}

	public function createTable()
	{
		if(!$this->db->tableExists(self::TABLE_NAME)) {
			$fields = [
				"username" => [
					"type" => "text",
					"length" => 80,
					"notnull" => true
				],
				"plugin" => [
					"type" => "text",
					"length" => 20,
					"notnull" => true
				]
			];
			$this->db->createTable(self::TABLE_NAME, $fields);
		}
	}

	public function addPrimaryKey()
	{
		try {
			$this->db->addPrimaryKey(self::TABLE_NAME, array("username", "plugin"));
		} catch (\PDOException $e) {
			$this->db->dropPrimaryKey(self::TABLE_NAME);
			$this->db->addPrimaryKey(self::TABLE_NAME, array("username", "plugin"));
		}
	}
}