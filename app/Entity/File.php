<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 파일
 *
 * @ORM\Entity
 */
class File
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
     * @var string crc32 해시값
     *
     * @ORM\Column(type="string")
     */
    public $hash_crc32;

    /**
     * @var \DateTime 업로드 시각(UTC)
     *
     * @ORM\Column(type="datetime")
     */
    public $createdAt;

    /**
     * @var int 크기(Bytes)
     *
     * @ORM\Column(type="integer")
     */
    public $size;

    /**
     * @var string 업로드 시 유형
     *
     * @ORM\Column(type="string")
     */
    public $mediaType;

    /**
     * @var string 업로드 시 이름
     *
     * @ORM\Column(type="string")
     */
    public $originalFilename;

    /**
     * @var string 저장소 내 이름
     *
     * @ORM\Column(type="string")
     */
    public $filename;

    /**
     * @var \App\Entity\User 소유자
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    public $owner;
}
