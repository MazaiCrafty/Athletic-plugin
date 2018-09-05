<?php

namespace athletic\game;

use pocketmine\Player;

use athletic\utils\PlayerModule;
use athletic\utils\Head;

class Game extends Head implements Athletic{

    private $player;
    private $athletic;

    private $isPlaying = false;

    public function __construct(Player $player = null, string $athletic = null){
        parent::__construct($player);
        $this->player = $player;
        $this->athletic = $athletic;
    }

    public function onStart(): void{
        $this->getPlayer()->sendMessage("チャレンジ開始");
        $this->isPlaying = true;
    }

    public function onFailed(): void{
        $this->getPlayer()->sendMessage("チャレンジ失敗");
        $this->isPlaying = false;
    }

    public function onClear(): void{
        // クリアタイムが上位なら PlayerHead APIで頭を設置する処理に移行する
        $this->getPlayer()->sendMessage("チャレンジ成功");
        $this->isPlaying = false;
        PlayerModule::getInstance()->removePlayerRepository($this->getPlayer());
    }

    public function isPlaying(): bool{
        return $this->isPlaying;
    }

    public function getPlayer(): Player{
        return $this->player;
    }

    public function getAthletic(): string{
        return $this->athletic;
    }
}
