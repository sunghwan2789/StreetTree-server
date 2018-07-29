<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 회원
 *
 * @ORM\Entity
 */
class User
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
     * @var string 아이디
     *
     * @ORM\Column(type="string", length=50, unique=true)
     */
    public $username;

    /**
     * @var string 비밀번호
     *
     * @ORM\Column(type="string", length=90)
     */
    public $password;

    /**
     * @var string 성명
     *
     * @ORM\Column(type="text")
     */
    public $fullName;


}
