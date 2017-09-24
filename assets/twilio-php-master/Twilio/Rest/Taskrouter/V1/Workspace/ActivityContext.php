<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;

class ActivityContext extends InstanceContext {
    /**
     * Initialize the ActivityContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $workspaceSid The workspace_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\ActivityContext 
     */
    public function __construct(Version $version, $workspaceSid, $sid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
            'sid' => $sid,
        );
        
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Activities/' . rawurlencode($sid) . '';
    }

    /**
     * Fetch a ActivityInstance
     * 
     * @return ActivityInstance Fetched ActivityInstance
     */
    public function fetch() {
        $params = Values::of(array());
        
        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );
        
        return new ActivityInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Update the ActivityInstance
     * 
     * @param string $friendlyName The friendly_name
     * @return ActivityInstance Updated ActivityInstance
     */
    public function update($friendlyName) {
        $data = Values::of(array(
            'FriendlyName' => $friendlyName,
        ));
        
        $payload = $this->version->update(
            'POST',
            $this->uri,
            array(),
            $data
        );
        
        return new ActivityInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Deletes the ActivityInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->version->delete('delete', $this->uri);
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.ActivityContext ' . implode(' ', $context) . ']';
    }
}