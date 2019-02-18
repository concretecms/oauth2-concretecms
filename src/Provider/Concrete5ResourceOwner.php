<?php

namespace Concrete\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Concrete5ResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response['data'];
    }

    /**
     * Get resource owner id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->response['id'] ?: null;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }

    /**
     * Get emailaddress
     *
     * @return string|null
     */
    public function getUserEmail()
    {
        return $this->response['email'] ?: null;
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->response['username'] ?: null;
    }

}