<?php namespace NukaCode\Core\Eventing;

use Illuminate\Events\Dispatcher;
use Illuminate\Log\Writer;

class EventDispatcher {

    protected $event;

    private   $log;

    function __construct(Dispatcher $event, Writer $log)
    {
        $this->event = $event;
        $this->log   = $log;
    }

    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $eventName = $this->getEventName($event);

            $this->event->fire($eventName, $event);

            $this->log->info("$eventName was fired");
        }
    }

    protected function getEventName($event)
    {
        $eventName = str_replace('\\', '.', get_class($event));

        return $eventName;
    }
} 