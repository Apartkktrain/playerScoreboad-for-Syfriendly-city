<?php
namespace apart\scoreboad\Task;

use pocketmine\plugin\Plugin;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\Player;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use metowa1227\moneysystem\api\core\API;
class scoreboadTask extends Task
{
	private $second;
	public function __construct(int $second)
	{
		$this->second = $second;
	}

	public function onRun(int $tick)
	{
		foreach (Server::getInstance()->getOnlinePlayers() as $player)
		{
			$c = Server::getInstance()->getOnlinePlayers();
			$count = count($c);
			$x = $player->getX();
			$y = $player->getY();
			$z = $player->getZ();
			$ip = $player->getAddress();
			$mymoney = API::getInstance()->get($player);

			$pk = new RemoveObjectivePacket();
			$pk->objectiveName = "score";
			$player->sendDataPacket($pk);

			$pk = new SetDisplayObjectivePacket();
			$pk->displaySlot = "sidebar";
			$pk->objectiveName = "score";
			$pk->displayName = "§aFriendly§bCtiy§cServer";
			$pk->criteriaName = "dummy";
			$pk->sortOrder = 0;
			$player->sendDataPacket($pk);

			$pk = new SetScorePacket();
			$pk->type = SetScorePacket::TYPE_CHANGE;

			$id = -1;
			$score = 0;

			$entry = new ScorePacketEntry();
			$entry->objectiveName = "score";
			$entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
			$entry->scoreboardId = ++$id;
			$entry->score = ++$score;
			$entry->customName = "§6座標:$x,$y,$z";
			$pk->entries[] = $entry;

			$entry = new ScorePacketEntry();
			$entry->objectiveName = "score";
			$entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
			$entry->scoreboardId = ++$id;
			$entry->score = ++$score;
			$entry->customName = "§e所持金:$mymoney 円";
			$pk->entries[] = $entry;

			$entry = new ScorePacketEntry();
			$entry->objectiveName = "score";
			$entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
			$entry->scoreboardId = ++$id;
			$entry->score = ++$score;
			$entry->customName = "§bオンライン:${c}人";
			$pk->entries[] = $entry;

			$entry = new ScorePacketEntry();
			$entry->objectiveName = "score";
			$entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
			$entry->scoreboardId = ++$id;
			$entry->score = ++$score;
			$entry->customName = "§aマイIP:$ip";
			$pk->entries[] = $entry;

			$player->sendDataPacket($pk);
		}
	}
}