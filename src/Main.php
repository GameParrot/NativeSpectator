<?php

namespace GameParrot\NativeSpectator;

use pocketmine\event\EventPriority;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\SetPlayerGameTypePacket;
use pocketmine\network\mcpe\protocol\StartGamePacket;
use pocketmine\player\GameMode;
use pocketmine\plugin\PluginBase;
use pocketmine\network\mcpe\protocol\types\GameMode as ProtocolGameMode;

class Main extends PluginBase implements Listener{
	public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvent(DataPacketSendEvent::class, function(DataPacketSendEvent $event) : void {
			foreach($event->getPackets() as $i=>$pk) {
				if (!isset($event->getTargets()[$i])) continue;
				if ($pk instanceof SetPlayerGameTypePacket) {
					if ($pk->gamemode == ProtocolGameMode::CREATIVE && $event->getTargets()[$i]->getPlayer()->getGamemode() == GameMode::SPECTATOR) {
						$pk->gamemode = 6;
					}
				}
				if ($pk instanceof StartGamePacket) {
					if ($pk->playerGamemode == ProtocolGameMode::CREATIVE && $event->getTargets()[$i]->getPlayer()->getGamemode() == GameMode::SPECTATOR) {
						$pk->playerGamemode = 6;
					}
				}
			}
		}, EventPriority::NORMAL, $this);

    }
}
