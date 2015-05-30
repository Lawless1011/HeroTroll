<?php

namespace HeroTroll/Commands;

use pocketmine\command\CommandSender;
use HeroTroll\Main;
use HeroTroll\CommandLoader;
use pocketmine\Server;
use pocketmine\Player;

class HeroWarn extends CommandLoader{
	public function onConstruct(Main $plugin){
		parent::__construct($plugin, "HeroWarn", "Sends a spokky message to the desired player", "/hw <player>");
		$this->setPermission("herotroll.hw");
	}
	public function execute(CommandSender $sender, $alias, array $args){
		if(!($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.hw"))){
			$sender->sendMessage("You don't have permission to do that!")
			return true;
		}else{
			if(!(isset($args[0]))){
				$sender->sendMessage("Usage: /hw <player>");
			}else{
				$player = $args;
				$getPlayer = $sender->getServer()->getPlayer($player);
				if($getPlayer instanceof Player){
					$message = $this->getConfig()->get("HeroWarn");
					$player->sendMessage("Warning: " .$message);
				}else{
					$sender->sendMessage("There is no player online by that name!");
				}
			}
		}
	}
}
