<?php

/* Copyright (c) 2018 Stefan Hecken <stefan.hecken@concepts-and-training.de> */

declare(strict_types=1);

namespace CaT\Security\PluginLogin\ILIAS;

class ilDB implements DB
{
	const TABLE_NAME = "allowed_usernames";

	public function __construct(\ilDBInterface $db)
	{
		$this->db = $db
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
		$table = $this->db->quote(self::TABLE_NAME, "text");
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
		$table = $this->db->quote(self::TABLE_NAME, "text");
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
		$table = $this->db->quote(self::TABLE_NAME, "text");
		$plugin = $this->db->quote($plugin, "text");
		$query = <<<EOT
SELECT count(username) AS cnt
FROM $table
WHERE plugin = $plugin
EOT;

		$res = $this->db->query($query);
		$row = $this->db->fetchAssoc();
		return $row["cnt"] > 0;
	}

	/**
	 * @inheritdoc
	 */
	public function deleteFor(string $plugin)
	{
		$table = $this->db->quote(self::TABLE_NAME, "text");
		$plugin = $this->db->quote($plugin, "text");
$query = <<<EOT
DELETE FROM $table
WHERE plugin = $plugin
EOT;

		$thid->db->manipulate($query);
	}

	public function createTable()
	{
		if(!$this->db->tableExists(self::TABLE_NAME)) {
			$fields = [
				"username" => [
					"type" => "integer",
					"length"	=> 4,
					"notnull"	=> true
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
		$this->db->addPrimaryKey(self::TABLE_NAME, array("username", "plugin"));
	}
}