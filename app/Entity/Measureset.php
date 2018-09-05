<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 실측 현장 정보
 *
 * @ORM\Entity
 */
class Measureset
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
     * @var string 현장명
     *
     * @ORM\Column(type="text")
     */
    public $siteName;

    /**
     * @var string 발주처
     *
     * @ORM\Column(type="text")
     */
    public $clientName;

    /**
     * @var \DateTime 실측 날짜
     *
     * @ORM\Column(type="date")
     */
    public $createdAt;

    /**
     * @var \App\Entity\User 담당자
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    public $author;

    /**
     * @var \App\Entity\Measure[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Measure", mappedBy="measureset")
     */
    public $measures;

    /**
     * @var string 영업담당자 이름
     *
     * @ORM\Column(type="text")
     */
    public $salespersonName;

    /**
     * @var string 납품대상
     *
     * 대상이 관급인지 사급인지 구분하는 값
     *
     * @ORM\Column(type="text")
     */
    public $deliveryTarget;

    /**
     * @var \DateTime 납품예정일
     *
     * @ORM\Column(type="date")
     */
    public $deliveryDate;

    /**
     * @var int 공차값
     *
     * @ORM\Column(type="integer")
     */
    public $differenceValue;

}
