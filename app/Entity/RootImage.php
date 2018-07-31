<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 수목뿌리 사진
 *
 * @ORM\Entity
 */
class RootImage
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
     * @var string 파일의 crc32 해시값
     *
     * @ORM\Column(type="string")
     */
    public $hash_crc32;

    /**
     * @var \DateTime 파일 업로드 시각(UTC)
     *
     * @ORM\Column(type="datetime")
     */
    public $createdAt;

    /**
     * @var int 파일의 크기(Bytes)
     *
     * @ORM\Column(type="integer")
     */
    public $size;

    /**
     * @var resource 파일 데이터
     *
     * @ORM\Column(type="blob")
     */
    public $data;

    /**
     * @var \App\Entity\User 업로더
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    public $author;
}
