<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oa_refresh_tokens")
 */
class OAuthRefreshTokens
{
    /**
     * @ORM\Id
     * @ORM\Column(length=40)
     */
    private $refreshToken;
    
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
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
    
    /**
     * @return User $user
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @return OAuthClient $client
     */
    public function getClient()
    {
        return $this->client;
    }
    
    /**
     * @return \DateTime $expires
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
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
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

