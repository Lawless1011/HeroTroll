<?php

namespace HeroTroll;

use HeroTroll\Commands\HeroWarn;
use HeroTroll\Commands\HeroMessage;
use HeroTroll\Commands\HeroTroll;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Main extends PluginBase{
	public function onLoad(){
		$this->getLogger()->info(TextFormat::YELLOE . "Loading...");
	}
	public function onEnable(){
		$this->getLogger()->info(TextFormat::BLUE . "HeroTroll enabled");
		$this->saveDefaultConfig();
	}
	public function onDisable(){
		$this->getLogger()->info(TextFormat::RED . "HeroTroll disabled");
	}
	private function registerCommands(){
		$this->getServer()->getCommandMap()->registerAll("herotroll", [
			new HeroTroll($this),
			new HeroMessage($this),
			new HeroWarn($this)
		]);
	}
}
