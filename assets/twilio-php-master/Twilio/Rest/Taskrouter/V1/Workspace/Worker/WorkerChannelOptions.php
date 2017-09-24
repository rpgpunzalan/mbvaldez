<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Options;
use Twilio\Values;

abstract class WorkerChannelOptions {
    /**
     * @param string $capacity The capacity
     * @param string $available The available
     * @return UpdateWorkerChannelOptions Options builder
     */
    public static function update($capacity = Values::NONE, $available = Values::NONE) {
        return new UpdateWorkerChannelOptions($capacity, $available);
    }
}

class UpdateWorkerChannelOptions extends Options {
    /**
     * @param string $capacity The capacity
     * @param string $available The available
     */
    public function __construct($capacity = Values::NONE, $available = Values::NONE) {
        $this->options['capacity'] = $capacity;
        $this->options['available'] = $available;
    }

    /**
     * The capacity
     * 
     * @param string $capacity The capacity
     * @return $this Fluent Builder
     */
    public function setCapacity($capacity) {
        $this->options['capacity'] = $capacity;
        return $this;
    }

    /**
     * The available
     * 
     * @param string $available The available
     * @return $this Fluent Builder
     */
    public function setAvailable($available) {
        $this->options['available'] = $available;
        return $this;
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Taskrouter.V1.UpdateWorkerChannelOptions ' . implode(' ', $options) . ']';
    }
}