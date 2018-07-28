<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Field
 *
 * @ORM\Entity
 * @ORM\Table(name="fields", indexes={@ORM\Index(name="user_seq", columns={"user_seq"})})
 */
class Field
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="field_seq", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $fieldSeq;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region_code", type="string", length=50, nullable=true, options={"comment"="지역코드"})
     */
    public $regionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="field_name", type="text", options={"comment"="현장명"})
     */
    public $fieldName;

    /**
     * @var string
     *
     * @ORM\Column(name="client_name", type="text", options={"comment"="발주처"})
     */
    public $clientName;

    /**
     * @var string
     *
     * @ORM\Column(name="survery_at", type="text")
     */
    public $surveryAt;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="text")
     */
    public $employeeName;

    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_seq", referencedColumnName="user_seq")
     * })
     */
    public $employee;


}
