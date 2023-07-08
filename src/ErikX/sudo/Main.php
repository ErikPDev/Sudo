<?php

namespace ErikX\sudo;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
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

    /**
     * Sourced from PocketMine Source Code
     * @param string $name
     * @return Player|null
     */
    private function getPlayerByPrefix(string $name) : ?Player{
        $found = null;
        $name = strtolower($name);
        $delta = PHP_INT_MAX;
        foreach($this->getServer()->getOnlinePlayers() as $player){
            if(stripos($player->getName(), $name) === 0){
                $curDelta = strlen($player->getName()) - strlen($name);
                if($curDelta < $delta){
                    $found = $player;
                    $delta = $curDelta;
                }
                if($curDelta === 0){
                    break;
                }
            }
        }
        return $found;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
      $prefix = TextFormat::GREEN . "[" . TextFormat::YELLOW . "Sudo" . TextFormat::GREEN . "] ";
      $usage = $this->getConfig()->get("usage");
      $notfound = $this->getConfig()->get("notfound");
        if (strtolower($command->getName()) == "sudo") {
            if (count($args) < 2) {
                $sender->sendMessage($prefix . $usage);
                return true;
            }
            $player = $this->getPlayerByPrefix(array_shift($args));
            if ($player instanceof Player) {
                $player->chat(trim(implode(" ", $args)));
            } else {
                $sender->sendMessage($prefix . $notfound);
            }
        }
      return true;
    }

}
