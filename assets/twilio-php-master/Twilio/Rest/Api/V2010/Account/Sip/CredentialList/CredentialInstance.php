<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Sip\CredentialList;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Version;

/**
 * @property string sid
 * @property string accountSid
 * @property string credentialListSid
 * @property string username
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string uri
 */
class CredentialInstance extends InstanceResource {
    /**
     * Initialize the CredentialInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The account_sid
     * @param string $credentialListSid The credential_list_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Api\V2010\Account\Sip\CredentialList\CredentialInstance 
     */
    public function __construct(Version $version, array $payload, $accountSid, $credentialListSid, $sid = null) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'sid' => $payload['sid'],
            'accountSid' => $payload['account_sid'],
            'credentialListSid' => $payload['credential_list_sid'],
            'username' => $payload['username'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'uri' => $payload['uri'],
        );
        
        $this->solution = array(
            'accountSid' => $accountSid,
            'credentialListSid' => $credentialListSid,
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Api\V2010\Account\Sip\CredentialList\CredentialContext Context for this CredentialInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new CredentialContext(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['credentialListSid'],
                $this->solution['sid']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a CredentialInstance
     * 
     * @return CredentialInstance Fetched CredentialInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Update the CredentialInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return CredentialInstance Updated CredentialInstance
     */
    public function update($options = array()) {
        return $this->proxy()->update(
            $options
        );
    }

    /**
     * Deletes the CredentialInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->proxy()->delete();
    }

    /**
     * Magic getter to access properties
     * 
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get($name) {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        
        throw new TwilioException('Unknown property: ' . $name);
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
        return '[Twilio.Api.V2010.CredentialInstance ' . implode(' ', $context) . ']';
    }
}