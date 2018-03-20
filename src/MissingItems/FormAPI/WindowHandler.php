<?php

namespace MissingItems\FormAPI;

use MissingItems\FormAPI\windows\CreateBannerWindow;
use MissingItems\FormAPI\windows\Window;
use pocketmine\Player;

class WindowHandler
{

    //Banner
    const WINDOW_CREATE_BANNER = 0;


    /** @var string[] */
    private $types = [
        //Banner
        CreateBannerWindow::class,
    ];

    /**
     * @param int $windowId
     * @param $loader
     * @param Player $player
     * @return string
     */
    public function getWindowJson(int $windowId, $loader, Player $player): string
    {
        return $this->getWindow($windowId, $loader, $player)->getJson();
    }

    /**
     * @param int $windowId
     * @param $loader
     * @param Player $player
     * @return Window
     */
    public function getWindow(int $windowId, $loader, Player $player): Window
    {
        if (!isset($this->types[$windowId])) {
            throw new \OutOfBoundsException("Tried to get window of non-existing window ID.");
        }
        return new $this->types[$windowId]($loader, $player);
    }

    /**
     * @param int $windowId
     * @return bool
     */
    public function isInRange(int $windowId): bool
    {
        return isset($this->types[$windowId]) || isset($this->types[$windowId + 3200]);
    }

    /**
     * @param int $windowId
     * @return int
     */
    public function getWindowIdFor(int $windowId): int
    {
        if ($windowId >= 3200) {
            return $windowId - 3200;
        }
        return 3200 + $windowId;
    }

}
