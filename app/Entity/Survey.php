<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Survey
 *
 * @ORM\Entity
 * @ORM\Table(name="surveys", indexes={@ORM\Index(name="field_seq", columns={"field_seq"})})
 */
class Survey
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="survey_seq", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $surveySeq;

    /**
     * @var int
     *
     * @ORM\Column(name="survey_number", type="integer")
     */
    public $surveyNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plate_name", type="text", nullable=true, options={"comment"="보호판?"})
     */
    public $plateName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tree_number", type="text", nullable=true, options={"comment"="수목번호"})
     */
    public $treeNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_installed", type="boolean")
     */
    public $isInstalled;

    /**
     * @var string
     *
     * @ORM\Column(name="points", type="text")
     */
    public $points;

    /**
     * @var resource|null
     *
     * @ORM\Column(name="picture", type="blob", nullable=true)
     */
    public $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="text")
     */
    public $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="text")
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
    public $field;


}
