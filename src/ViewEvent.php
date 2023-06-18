<?php

namespace Phpshots\Viewmodel;
use Phpshots\Viewmodel\Interfaces\EventInterface;

abstract class ViewEvent implements EventInterface {
    protected $eventCallbacks = [];

    /**
     * Register the event callbacks.
     */
    abstract protected function registerCallbacks();

    /**
     * Get the registered event callbacks.
     *
     * @return array
     */
    public function getEventCallbacks():array {
        $this->registerCallbacks();
        return $this->eventCallbacks;
    }
}
