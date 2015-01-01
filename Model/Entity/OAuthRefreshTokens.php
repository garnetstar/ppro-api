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
     * @ORM\Column(type="time")
     */
    private $expires;
    
    /**
     * @ORM\Column(length=2000)
     */
    private $scope;
}

