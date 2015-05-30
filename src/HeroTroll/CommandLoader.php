<?php

namespace HeroTroll;

use pocketmine\command\Command;
use pocketmine\command\PluginIdentifiableCommand;

abstract class CommandLoader extends Command implements PluginIdentifiableCommand{
	private $plugin;
	
	public function __construct(Main $plugin, $name, $description = "", $usageMessage = null){
		parent::__construct($name, $description, $usageMessage);
		$this->plugin = $plugin
	}
	public final function getPlugin(){
		return $this->plugin;
	}
}
