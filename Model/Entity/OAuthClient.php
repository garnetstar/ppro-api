<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oa_client")
 */
class OAuthClient
{

    /**
     * @ORM\Id
     * @ORM\Column(length=80)
     */
    private $clientId;

    /**
     * @ORM\Column(length=80)
     */
    private $clientSecret;

    /**
     * @ORM\Column(length=2000)
     */
    private $redirectUri;

    /**
     * @ORM\Column(length=80)
     */
    private $grantType;

    /**
     * @ORM\Column(length=2000)
     */
    private $scope;

    /**
     * @ORM\Column(length=255)
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="OAuthAccessTokens", mappedBy="client")
     */
    protected $accessTokens;
    
    /**
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
}


