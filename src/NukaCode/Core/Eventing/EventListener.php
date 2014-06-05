<?php namespace NukaCode\Core\Eventing;

use ReflectionClass;

abstract class EventListener {

    public function handle($event)
    {
        $eventName = $this->getEventName($event);

        if ($this->listenerIsRegistered($eventName)) {
            return call_user_func([$this, 'when'.$eventName], $event);
        }
    }

    protected function getEventName($event)
    {
        return (new ReflectionClass($event))->getShortName();
    }

    protected function listenerIsRegistered($eventName)
    {
        $method = "when{$eventName}";

        return method_exists($this, $method);
    }
}