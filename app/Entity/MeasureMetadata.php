<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 실측 현장 정보
 *
 * @ORM\Entity
 */
class MeasureMetadata
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
     * @var string|null 현장 지역코드
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    public $siteRegionCode;

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
     * @var string 담당자 성명
     *
     * @ORM\Column(type="text")
     */
    public $authorFullName;


}
