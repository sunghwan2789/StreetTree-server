<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_seq", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $userSeq;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=50, nullable=false)
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="pw", type="string", length=90, nullable=false)
     */
    public $pw;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     */
    public $name;


}
