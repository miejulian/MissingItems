<?php
/**
 * Created by PhpStorm.
 * User: McpeBooster
 * Date: 20.03.2018
 * Time: 17:39
 */

namespace MissingItems\Listener;


use MissingItems\FormAPI\WindowHandler;
use MissingItems\MissingItems;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

class onDataPacketReceive implements Listener {

    public function __construct(MissingItems $plugin) {
        $this->plugin = $plugin;
    }

    public function onDataPacketReceive(DataPacketReceiveEvent $event) {
        $packet = $event->getPacket();
        $player = $event->getPlayer();
        if($packet instanceof ModalFormResponsePacket) {
            if(json_decode($packet->formData, true) === null) {
                return;
            }
            $windowHandler = new WindowHandler();
            $packet->formId = $windowHandler->getWindowIdFor($packet->formId);
            if(!$windowHandler->isInRange($packet->formId)) {
                return;
            }
            $window = $windowHandler->getWindow($packet->formId, $this->plugin, $event->getPlayer());
            $window->handle($packet);
        }
    }

}