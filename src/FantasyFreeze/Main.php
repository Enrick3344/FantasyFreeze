/*
 * 
 *  _____           _                  _____                      
 * |  ___|_ _ _ __ | |_ __ _ ___ _   _|  ___| __ ___  ___ _______ 
 * | |_ / _` | '_ \| __/ _` / __| | | | |_ | '__/ _ \/ _ \_  / _ \
 * |  _| (_| | | | | || (_| \__ \ |_| |  _|| | |  __/  __// /  __/
 * |_|  \__,_|_| |_|\__\__,_|___/\__, |_|  |_|  \___|\___/___\___|
 *                               |___/                            
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 *
 * @author Enrick Fortier
 * 
 * Github: https://github.com/Enrick3344
 * Version: v0.1
 *
*/ 

namespace FantasyFreeze;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase impliments Listener{

  public function onEnable(){
		if(!file_exists($this->getDataFolder() . "config.yml")){
     			 @mkdir($this->getDataFolder());
     			 file_put_contents($this->getDataFolder()."config.yml", $this->getResource("config.yml"));
   		 }
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->notice(TextFormat::AQUA . "FantasyFreeze Enabled!");
	 }
   
   public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
     switch($command->getName()){
       case "freeze":{
       		if(isset($args[0])){
				    $victim = $args[0];
            $player = $this->getServer()->getPlayer($victim);
					    if($player === null) {
						    $sender->sendMessage("§5>§c " . $victim . " Isnt a valid player Or is Not Online!");
						  }else{
							  $freeze = $this->freeze->get("Frozen");
							  $name = $player->getName();
							    if(in_array($name, $freeze)) {
								    $sender->sendMessage("§5>§c " . $name . " Is Already Frozen!");
							    }else{
								    $array = $this->freeze->get("Frozen");
								    $frozen = $array;
								    $frozen[] = $player->getName();
								    $this->freeze->set("Frozen", $frozen);
								    $this->freeze->save();
								    $sender->sendMessage("§5>§d You have Successfully Froze " . $name);
							    }
						  }else{
						$sender->sendMessage("§l§dUsage§5>§r§b /freeze <player>");
					}
					return true;
				}
      case "unfreeze":{
        if(isset($args[0])) {
			    $victim = $args[0];
			    $player = $this->getServer()->getPlayer($victim);
				    if($player === null) {
						  $sender->sendMessage("§5>§c " . $victim . " Isnt a valid player Or is Not Online!");
						}else{
							$freeze = $this->freeze->get("Frozen");
							$name = $player->getName();
								if(in_array($name, $freeze)){
									$array = $this->freeze->get("Frozen");
									$rm = $player->getName();
									$frozen = [];
									foreach($array as $value){
										if($value != $rm) {
										$config[] = $value;
										}
									}
									$this->freeze->set("Frozen", $frozen);
									$this->freeze->save();
									$sender->sendMessage("§5>§d You Have Sucessfully Unfroze " . $name);
								}else{
									$sender->sendMessage("§5>§c ".$name." Isn't Frozen!");
								}
					
						}else{
						$sender->sendMessage("§l§dUsage§5>§r§b /unfreeze <player>");
					}
					return true;
				}
      
      }
   }
   
   
   
}
