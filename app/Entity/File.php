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
     * @var string 유형
     *
     * @ORM\Column(type="string")
     */
    public $mimeType;

    /**
     * @var string 확장자
     *
     * @ORM\Column(type="string")
     */
    public $extension;

    /**
     * @var string 이름
     *
     * @ORM\Column(type="string", nullable=true)
     */
    public $filename;

    /**
     * @var resource 데이터
     *
     * @ORM\Column(type="blob")
     */
    public $data;

    /**
     * @var \App\Entity\User 소유자
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    public $owner;
}
