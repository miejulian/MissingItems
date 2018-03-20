<?php

namespace MissingItems\FormAPI\windows;

use MissingItems\MissingItems;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\Player;

abstract class Window {

	protected $loader = null;
	protected $player = null;
	protected $data = [];

	public function __construct($loader, Player $player) {
		$this->loader = $loader;
		$this->player = $player;
		$this->process();
	}

    /**
     * @return string
     */
	public function getJson(): string {
		return json_encode($this->data);
	}

    /**
     * @return MissingItems
     */
	public function getLoader(): MissingItems {
		return $this->loader;
	}

    /**
     * @return Player
     */
	public function getPlayer(): Player {
		return $this->player;
	}
	protected abstract function process(): void;

    /**
     * @param ModalFormResponsePacket $packet
     * @return bool
     */
	public abstract function handle(ModalFormResponsePacket $packet): bool;
}