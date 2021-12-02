<?php

namespace ErikX\sudo;

use pocketmine\plugin\PluginBase;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\event\Listener;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;


class Main extends PluginBase implements Listener {

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->saveDefaultConfig();
        $this->reloadConfig();
      }
    public function onLoad() : void {
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
            $player->chat(trim(implode(" ", $args))); //$this->getServer()->dispatchCommand($player, trim(implode(" ", $args)));
        } else {
            $sender->sendMessage($prefix. $notfound);
        }
      }
      return true;
    }

}
