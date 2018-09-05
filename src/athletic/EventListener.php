<?php

namespace athletic;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;

use athletic\Main;

use athletic\utils\PlayerModule;
use athletic\game\AthleticManager;

class EventListener implements Listener{

    public function __construct(Main $plugin){
        $this->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    public function onInteract(PlayerInteractEvent $event): void{
        if ($event->getBlock() === "1"){
            $athletic = AthleticManager::existsAthletic($event->getTouchVector());
            $module = PlayerModule::getInstance();
            $module->setPlayer($event->getPlayer(), $athletic);
            $module->onStart();
        }
    }

    public function onVoidLoop(PlayerMoveEvent $event): void{
        $player = $event->getPlayer();
        if ($player->getLevel()->getName() === "test"){
            return;
        }
        if ($event->getTo()->getFloorY() < 3){
            $module = PlayerModule::getInstance();
            if (!$module->existsPlayerRepository($player)){
                return;
            }
            $repository = $module->getPlayerRepository();
            if ($repository->isPlaying()){
                $repository->onFailed();
            }
        }
    }
}
