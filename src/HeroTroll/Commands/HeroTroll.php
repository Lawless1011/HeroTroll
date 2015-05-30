<?php

namespace HeroTroll\Commands

use HeroTroll\CommandLoader;
use HeroTroll\Main;
use pocketmine\CommandSender;

class HeroTroll extends CommandLoader{
	public function __construct(Main $plugin){
		parent::__construct($plugin, "HeroTroll", "Shows a list of commands in the HeroTroll plugin", "/ht <page>");
		$this->setPermission("herotroll.ht");
	}
	
	public function execute(CommandSender $sender, $alias, array $args){
		if(!($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.ht"))){
			$sender->sendMessage("You don't have permission to do that!");
			return true;
		}else{
			if(isset($args[0])){
				if($args[0] == "1"){
					$sender->sendMessage("Showing 1 out of 1 page of HeroTroll commands.");
					$sender->sendMessage("HeroMessage: /hm <message>");
					$sender->sendMessage("HeroWarn: /hw <player>");
				}else{
					$sender->sendMessage("Usage: /ht");
				}
			}else{
				$sender->sendMessage("Showing 1 out of 1 page of HeroTroll commands.");
				$sender->sendMessage("HeroMessage: /hm <message>");
				$sender->sendMessage("HeroWarn: /hw <player>");
			}
		}
	}
}
