<?php

namespace HeroTroll;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\Server;

class Main extends PluginBase{
	public function onEnable(){
		$this->getLogger()->info(TextFormat::BLUE . "HeroTroll enabled");
		$this->saveDefaultConfig();
	}
	public function onDisable(){
		$this->getLogger()->info(TextFormat::RED . "HeroTroll disabled");
	}
	
	// This next part is for the HeroUsername command
	private function heroName(Player $player){
		$player->setNameTag("Herobrine");
		$player->sendMessage("Your username is Herobrine!");
	}
	private function offHeroName(Player $player){
		$player->setNameTag($player->getDisplayName());
		$player->sendMessage("Your name has been restored");
	}
	
	
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch($command->getName()){
			case "ht":
			if($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.ht")){
				if(isset($args[0])){
					if($args[0] == "1"){
						$sender->sendMessage("Showing page 1 of 1:");
						$sender->sendMessage("/hm: Sends a message to chat with the username as herobrine");
						$sender->sendMessage("/hw: Sends the desired player a spooky message");
					}elseif($args[0] == "2"){
						$sender->sendMessage("More commands coming soon!");
					}
					return true;
				}else{
					$sender->sendMessage("Please choose a page");
					return false;
				}
			}else{
				$sender->sendMessage("You don't have permission to do that!");
				return true;
		}
		case "hm":
		if($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.hm")){
			if(!(isset($args[0]))){
				return false;
			}else{
				$this->getServer()->broadcastMessage("<Herobrine> " .implode(" ", $args));
				$know = $this->getConfig()->get("ConsoleKnow");
				if($know == "true"){
					$player = $sender->getDisplayName();
					$this->getLogger()->info(TextFormat::YELLOW .$player.  " used the HeroMessage command");
				}
				return true;
			}
		}
		case "hw":
		if(!($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.hw"))){
			$sender->sendMessage("You don't have permission to do that!");
			return true;
		}else{
			if(isset($args[0])){
				$player = $sender->getServer()->getPlayer($args[0]);
				if($player !== null and $player->isOnline()){
					$player->sendMessage($this->getConfig()->get("HeroWarn"));
					$sender->sendMessage("Your message has been sent!");
					return true;
				}else{
					$sender->sendMessage("Player " .$args[0]. " not found!");
					return true;
				}
			}else{
				return false;
			}
		}
		case "hu":
		if($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.hu")){
			if(isset($args[0])){
				if($args[0] == "on"){
					if($sender->getNameTag() == $sender->getDisplayName()){
						$this->heroName($sender);
						return true;
					}else{
						$player->sendMessage("Your username is already Herobrine!");
						return true;
					}
				}elseif($args[0] == "off"){
						if($sender->getNameTag() == $sender->getDisplayName()){
							$this->offHeroName($sender);
							$sender->sendMessage("Your username has been restored");
							return true;
						}else{
							$sender->sendMessage("Your username is already herobrine!");
							return true;
						}
					}
				}else{
					return false;
				}
			}else{
				$sender->sendMessage("You don't have permission to do that!");
				return true;
			}
		}
	}
}
}

