<?php

declare(strict_types=1);

namespace MulqiGaming64\ServerInfo\libs\jojoe77777\FormAPI;

use pocketmine\Player;
use pocketmine\form\Form as IForm;
use pocketmine\Server;

abstract class Form implements IForm
{

	protected $data = [];
	/** @var callable */
	private $callable;

	private $destroyForm;

	/**
	 * @param callable $callable
	 */
	public function __construct(?callable $callable)
	{
		$this->callable = $callable;
	}

	/**
	 * @param Player $player
	 */
	public function sendToPlayer(Player $player): void
	{
		$player->sendForm($this);
		
	}

	public function destroy(): void
	{
		$this->destroyForm = true;
	}

	public function setCallable(?callable $callable)
	{
		$this->callable = $callable;
	}

	public function getCallable(): ?callable
	{
		return $this->callable;
	}

	public function processData(&$data): void
	{
	}

	public function jsonSerialize()
	{
		return $this->data;
	}

	public function handleResponse(Player $player, $data): void
	{
		if ($this->destroyForm) return;
		$this->processData($data);
		$callable = $this->getCallable();
		if ($callable !== null) {
			$callable($player, $data);
		}
	}
}
