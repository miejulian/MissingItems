<?php
/**
 * Created by PhpStorm.
 * User: McpeBooster
 * Date: 20.03.2018
 * Time: 17:24
 */

namespace MissingItems\Commands;


use MissingItems\FormAPI\WindowHandler;
use MissingItems\MissingItems;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\Player;

class CommandBanner extends Command {

    public function __construct(MissingItems $plugin) {
        $this->plugin = $plugin;
        parent::__construct("banner", "Create your own banner!", "/banner");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            $player = $sender;
            if($player->hasPermission("missingitems.banner")) {
                $windowHandler = new WindowHandler();
                $packet = new ModalFormRequestPacket();
                $packet->formId = $windowHandler->getWindowIdFor(WindowHandler::WINDOW_CREATE_BANNER);
                $packet->formData = $windowHandler->getWindowJson(WindowHandler::WINDOW_CREATE_BANNER, $this->plugin, $player);
                $player->dataPacket($packet);
                return true;
            }
        }
        $sender->sendMessage(MissingItems::PREFIX . " by §6McpeBooster§7!");
    }

}