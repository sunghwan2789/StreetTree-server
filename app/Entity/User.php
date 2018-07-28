<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="user_seq", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $userSeq;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=50)
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="pw", type="string", length=90)
     */
    public $pw;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    public $name;


}
