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
						$sender->sendMessage("/hu: Changes your nametag to Herobrine");
						$sender->sendMessage("huon: Changes a player's nametag to Herobrine");
						$sender->sendMessage("huoff: Changes a player's nagetag back to normal");
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
					if($sender instanceof Player){
						$player = $sender->getDisplayName();
						$this->getLogger()->info(TextFormat::YELLOW .$player.  " used the HeroMessage command");
					}
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
					$player->sendMessage("Warning: " .$this->getConfig()->get("HeroWarn"));
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
			if($sender instanceof Player){
				if(isset($args[0])){
					if($args[0] == "on"){
							$this->heroName($sender);
							return true;
					}elseif($args[0] == "off"){
							$this->offHeroName($sender);
							$sender->sendMessage("Your username has been restored");
							return true;
						}
					}else{
						return false;
					}
				}else{
					$sender->sendMessage(TextFormat::YELLOW . "Please run that command in-game");
					return true;
				}
			}else{
				$player->sendMessage("You don't have permission to do that!");
				return true;
			}
		case "huoff":
		if($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.huoff")){
			if(!(isset($args[0]))){
				return false;
			}else{
				$player = $sender->getServer()->getPlayer($args[0]);
				if($player !== null and $player->isOnline()){
					if($player->getNameTag() == "Herobrine"){
						$this->offHeroName($player);
						$sender->sendMessage($player->getDisplayName() . "'s name has been restored");
						return true;
					}else{
						$sender->sendMessage("That player's name isn't Herobrine!");
						return true;
					}
				}else{
					$sender->sendMessage("Player " .$args[0]. " not found");
					return true;
				}
			}
		}else{
			$sender->sendMessage("You don't have permission to do that!");
			return true;;
		}
		case "huon":
		if($sender->hasPermission("herotroll") || $sender->hasPermission("herotroll.huon")){
			if(!(isset($args[0]))){
				return false;
			}else{
				$player = $sender->getServer()->getPlayer($args[0]);
				if($player !== null and $player->isOnline()){
					$this->heroName($player);
					$sender->sendMessage($player->getDisplayName(). "'s name tag is now herobrine");
					return true;
				}else{
					$sender->sendMessage("Player " .$args[0]. " not found");
					return true;
				}
			}
		}else{
			$sender->sendMessage("You don't have permission to do that!");
			return true;
		}
		// case here
	}
}
}
