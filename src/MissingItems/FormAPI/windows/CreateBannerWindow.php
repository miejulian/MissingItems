<?php

namespace MissingItems\FormAPI\windows;

use pocketmine\item\Banner;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

class CreateBannerWindow extends Window {

    public $pattern = ["bs", "ts", "ls", "rs", "cs", "ms", "drs", "dls", "ss", "cr", "sc", "ld", "rud", "lud", "rd", "vh", "vhr", "hh", "hhb", "bl", "br", "tl", "tr", "bt", "tt", "bts", "tts", "mc", "mr", "bo", "cbo", "bri", "gra", "gru", "cre", "sku", "flo", "moj"];

    public function process(): void {
        $this->data = [
            "type" => "custom_form",
            "title" => "Create your own Banner",
            "content" => [
                ["type" => "dropdown", "text" => "§6Main-Color", "options" => ["Black", "Red", "Green", "Brown", "Blue", "Purple", "Cyan", "Light Gray", "Gray", "Pink", "Lime", "Yellow", "Light Blue", "Magenta", "Orange", "White"], "default" => 0],
                ["type" => "dropdown", "text" => "§6Pattern", "options" => ["Bottom Stripe", "Top Stripe", "Left Stripe", "Right Stripe", "Center Stripe", "Middle Stripe", "Down Right Stripe", "Down Left Stripe", "Small Stripes", "Diagonal Cross", "Square Cross", "Left of Diagonal", "Right of Upside Down Diagonal", "Left of Upside Down Diagonal", "Right of Diagonal", "Vertical Half Left", "Vertical Half Right", "Horizontal Half Top", "Horizontal Half Bottom", "Bottom Left Corner", "Bottom Right Corner", "Top Left Corner", "Top Right Corner", "Bottom Triangle", "Top Triangle", "Bottom Triangle Sawtooth", "Top Triangle Sawtooth", "Middle Circle", "Middle Rhombus", "Border", "Curly Border", "Brick", "Gradient", "Gradient Upside Down", "Creeper", "Skull", "Flower", "Mojang"], "default" => 0],
                ["type" => "dropdown", "text" => "§6Pattern-Color", "options" => ["Black", "Red", "Green", "Brown", "Blue", "Purple", "Cyan", "Light Gray", "Gray", "Pink", "Lime", "Yellow", "Light Blue", "Magenta", "Orange", "White"], "default" => 0]
            ]
        ];
    }

    /**
     * @param ModalFormResponsePacket $packet
     * @return bool
     */
    public function handle(ModalFormResponsePacket $packet): bool {
        $data = $packet->formData;

        $data = str_replace("\n", "", $data);
        $data = str_replace("[", "", $data);
        $data = str_replace("]", "", $data);
        $data = explode(",", $data);

        $item = Item::get(446, $data[0]);
        if($item instanceof Banner) {
            $item->correctNBT();
            $item->addPattern($this->pattern[$data[1]], $data[2]);
            $item->setBaseColor($data[0]);
        }
        $this->player->getInventory()->addItem($item);
        return true;
    }

}
