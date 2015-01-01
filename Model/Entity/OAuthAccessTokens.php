<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oa_access_tokens")
 */
class OAuthAccessTokens
{
    /**
     * @ORM\Id
     * @ORM\Column(length=40)
     */
    private $accessToken;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="accessTokens")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="OAuthClient", inversedBy="accessTokens")
     * @ORM\JoinColumn(name="clientId", referencedColumnName="clientId", nullable=false)
     */
    private $client;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $expires;
    
    /**
     * @ORM\Column(length=2000, nullable=true)
     */
    private $scope;
    
	/**
     * @return the $accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

	/**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

	/**
     * @return the $client
     */
    public function getClient()
    {
        return $this->client;
    }

	/**
     * @return the $expires
     */
    public function getExpires()
    {
        return $this->expires;
    }

	/**
     * @return the $scope
     */
    public function getScope()
    {
        return $this->scope;
    }

	/**
     * @param string` $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

	/**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

	/**
     * @param OAuthClient $client
     * @return $this
     */
    public function setClient(OAuthClient $client)
    {
        $this->client = $client;
        return $this;
    }

	/**
     * @param field_type $expires
     * @return $this
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
        return $this;
    }

	/**
     * @param field_type $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }
    
}

