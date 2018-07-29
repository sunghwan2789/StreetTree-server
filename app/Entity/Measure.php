<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 실측 데이터
 *
 * @ORM\Entity
 */
class Measure
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var int 현장 내 실측 번호
     *
     * @ORM\Column(type="integer")
     */
    public $sequenceNumber;

    /**
     * @var string 수목 위치(위도)
     *
     * @ORM\Column(type="string")
     */
    public $latitude;

    /**
     * @var string 수목 위치(경도)
     *
     * @ORM\Column(type="string")
     */
    public $longitude;

    /**
     * @var string|null 보호판 이름?
     *
     * @ORM\Column(type="text", nullable=true)
     */
    public $plateName;

    /**
     * @var string|null 수목 번호
     *
     * @ORM\Column(type="text", nullable=true)
     */
    public $treeNumber;

    /**
     * @var bool ?설치 여부
     *
     * @ORM\Column(type="boolean")
     */
    public $isInstalled;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    public $points;

    /**
     * @var resource|null 수목 뿌리 사진
     *
     * @ORM\Column(type="blob", nullable=true)
     */
    public $picture;

    /**
     * @var \App\Entity\MeasureMetadata
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MeasureMetadata")
     */
    public $metadata;


}