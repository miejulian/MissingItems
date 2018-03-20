<?php
/**
 * Created by PhpStorm.
 * User: McpeBooster
 * Date: 20.03.2018
 * Time: 10:55
 */

namespace MissingItems;


use MissingItems\Commands\CommandBanner;
use MissingItems\Listener\onDataPacketReceive;
use pocketmine\plugin\PluginBase;

class MissingItems extends PluginBase {

    const PREFIX = "§7[§6MissingItems§7]";

    public static $instance;

    public function onEnable() {
        $this->getLogger()->info(self::PREFIX . " by §6McpeBooster§7!");

        self::$instance = $this;

        $this->checkUpdate();

        $this->getServer()->getPluginManager()->registerEvents(new onDataPacketReceive($this), $this);

        $this->getServer()->getCommandMap()->register("MissingItems", new CommandBanner($this));
    }

    /**
     * @return MissingItems
     */
    public static function getInstance(): MissingItems {
        return self::$instance;
    }

    /**
     * @return bool
     */
    public function checkUpdate() {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $datei = file_get_contents("https://raw.githubusercontent.com/McpeBooster/MissingItems-McpeBooster/master/plugin.yml", false, stream_context_create($arrContextOptions));
        if (!$datei)
            return false;
        $datei = str_replace("\n", "", $datei);
        $newversion = explode("version: ", $datei);
        $newversion = explode("api: ", $newversion[1]);
        $newversion = $newversion[0];
        //var_dump($newversion);
        $plugin = $this->getServer()->getPluginManager()->getPlugin("MissingItems");
        $version = $plugin->getDescription()->getVersion();
        //var_dump($version);
        if (!($version === $newversion)) {
            $update = false;
            if (intval($version[0]) < intval($newversion[0])) {
                $update = true;
            } elseif (intval($version[0]) === intval($newversion[0])) {
                if (intval($version[1]) < intval($newversion[1])) {
                    $update = true;
                } elseif (intval($version[1]) === intval($newversion[1])) {
                    if (intval($version[2]) < intval($newversion[2])) {
                        $update = true;
                    }
                }
            }
            if ($update) {
                $this->getLogger()->info("§aNew Update available!");
                $this->getLogger()->info("§7Local Version: §6" . $version);
                $this->getLogger()->info("§7Newest Version: §6" . $newversion);
                $this->getLogger()->info("§aPlease Download the Newest Version... §7(" . $newversion . ")");
                return true;
            }
        }
        $this->getLogger()->info("§aMissingItems has the Latest Version!");
        $this->getLogger()->info("§7Local Version: §6" . $version);
        $this->getLogger()->info("§7Newest Version: §6" . $newversion);
        return false;
    }

}