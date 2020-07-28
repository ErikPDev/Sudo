<?php

namespace ErikX\sudo;

use pocketmine\plugin\PluginBase;

// Event
use pocketmine\event\player\PlayerJoinEvent;  //This is the event
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;


class Main extends PluginBase implements Listener { //Added "implements Listener" because of the Listener event

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this,$this); // This is the new line
        $this->saveDefaultConfig(); // Saves config.yml if not created.
        $this->reloadConfig(); // Fix bugs sometimes by getting configs values
      }
    public function onLoad(){
      $this->reloadConfig();
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
      $prefix = TextFormat::GREEN . "[" . TextFormat::YELLOW . "Sudo" . TextFormat::GREEN . "] ";
      $usage = $this->getConfig()->get("usage");
      $notfound = $this->getConfig()->get("notfound");
      switch (strtolower($cmd->getName())) {
        case "sudo":
          if (count($args) < 2) {
            $sender->sendMessage($prefix . $usage);
            return true;
        }
        $player = $this->getServer()->getPlayer(array_shift($args));
        if ($player instanceof Player) {
            //$this->getServer()->dispatchCommand($player, trim(implode(" ", $args)));
            $player->chat(trim(implode(" ", $args)));
            return true;
        } else {
            $sender->sendMessage($prefix. $notfound);
            return true;

        }
      }
      return true;
    }

}
