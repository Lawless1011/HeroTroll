<?php

namespace HeroTroll\Commands;

use pocketmine\CommandSender;
use HeroTroll\CommandLoader;
use HeroTroll\Main;
use pocketmine\utils\Config;

class HeroMessage extends CommandLoader{
	public function __construct(Main $plugin){
		parent::__construct($plugin, "HeroMessage", "Send a message to chat with the username as Herobrine", "/hm <message>");
		$this->setPermission("herotroll.hm");
	}
	public function execute(CommandSender $sender, $alias, array $args){
		if(!($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.hm"))){
			$sender->sendMessage("You don't have permission to do that!");
			return true;
		}else{
			if(!(isset($args[0]))){
				$sender->sendMessage("Usage: /hm <message>");
				return true;
			}else{
				$this->getServer()->broadcastMessage("<Herobrine> " .implode(" ", $args));
				$ck = $this->getConfig()->get("ConsoleKnow");
				if($ck == "true"){
					$this->getLogger()->info(TextFormat::YELLOW . $sender->getDisplayName(). " used the HeroMessage command")
				}
				return true;
			}
		}
	}
}
