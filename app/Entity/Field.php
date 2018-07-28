<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Field
 *
 * @ORM\Table(name="fields", indexes={@ORM\Index(name="user_seq", columns={"user_seq"})})
 * @ORM\Entity
 */
class Field
{
    /**
     * @var int
     *
     * @ORM\Column(name="field_seq", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $fieldSeq;

    /**
     * @var string
     *
     * @ORM\Column(name="field_name", type="text", length=65535, nullable=false, options={"comment"="???"})
     */
    public $fieldName;

    /**
     * @var string
     *
     * @ORM\Column(name="region_code", type="string", length=50, nullable=false, options={"comment"="????"})
     */
    public $regionCode;

    /**
     * @var int
     *
     * @ORM\Column(name="client_name", type="integer", nullable=false)
     */
    public $clientName;

    /**
     * @var string
     *
     * @ORM\Column(name="survery_at", type="text", length=65535, nullable=false)
     */
    public $surveryAt;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=80, nullable=false)
     */
    public $userName;

    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_seq", referencedColumnName="user_seq")
     * })
     */
    public $userSeq;


}
