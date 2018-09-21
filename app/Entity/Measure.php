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
     * @var string|null 지역코드(시)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    public $siCode;

    /**
     * @var string|null 지역코드(구)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    public $guCode;

    /**
     * @var string|null 지역코드(동)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    public $dongCode;

    /**
     * @var Plate 보호판
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Plate")
     */
    public $plate;

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
     * @var \App\Entity\File 수목 뿌리 사진
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\File")
     */
    public $rootImage;

    /**
     * @var \App\Entity\Measureset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Measureset", inversedBy="measures")
     */
    public $measureset;

    /**
     * @var string|null 현장 수목 위치
     *
     * @ORM\Column(type="string", nullable=true)
     */
    public $treeLocation;

    /**
     * @var string|null 메모
     *
     * @ORM\Column(type="string", nullable=true)
     */
    public $memo;

    /**
     * @var \App\Entity\File 첨부 파일
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\File")
     */
    public $attachment;

}
