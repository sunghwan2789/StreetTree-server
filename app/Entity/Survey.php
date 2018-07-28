<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Survey
 *
 * @ORM\Table(name="surveys", indexes={@ORM\Index(name="field_seq", columns={"field_seq"})})
 * @ORM\Entity
 */
class Survey
{
    /**
     * @var int
     *
     * @ORM\Column(name="survey_seq", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $surveySeq;

    /**
     * @var int
     *
     * @ORM\Column(name="survey_number", type="integer", nullable=false, options={"unsigned"=true})
     */
    public $surveyNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="plate_name", type="text", length=65535, nullable=false, options={"comment"="보호판?"})
     */
    public $plateName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tree_number", type="text", length=65535, nullable=true)
     */
    public $treeNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_installed", type="boolean", nullable=false)
     */
    public $isInstalled;

    /**
     * @var string
     *
     * @ORM\Column(name="points", type="text", length=65535, nullable=false)
     */
    public $points;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="blob", length=0, nullable=false)
     */
    public $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="text", length=65535, nullable=false)
     */
    public $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="text", length=65535, nullable=false)
     */
    public $longitude;

    /**
     * @var \App\Entity\Field
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Field")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="field_seq", referencedColumnName="field_seq")
     * })
     */
    public $fieldSeq;


}
