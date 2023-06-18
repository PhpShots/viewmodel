<?php

namespace Phpshots\Viewmodel\Interfaces;


interface ViewModelInterface {
    public function setEventConfig(EventInterface $eventConfig);
    public function addEventCallback(string $eventName, callable $callback, int $priority = 0);
}