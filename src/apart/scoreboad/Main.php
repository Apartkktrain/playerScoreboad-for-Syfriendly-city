<?php
namespace apart\scoreboad;

use pocketmine\block\Concrete;
use pocketmine\block\Stone;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\item\Durable;
use pocketmine\level\generator\object\BirchTree;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;

use pocketmine\scheduler\Task;

use apart\scoreboad\Task\scoreboadTask;

class Main extends PluginBase implements Listener
{
	public function onEnable()
	{
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getScheduler()->scheduleRepeatingTask(new scoreboadTask(1),20);
	}
}