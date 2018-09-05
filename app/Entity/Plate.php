<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 수목 보호판
 *
 * @ORM\Entity
 */
class Plate
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    public $id;

    /**
     * @var int 폭
     *
     * @ORM\Column(type="integer")
     */
    public $width;

    /**
     * @var int 길이
     *
     * @ORM\Column(type="integer")
     */
    public $length;

    /**
     * @var int|null 내경
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    public $innerDiameter;

    /**
     * @var int 높이
     *
     * @ORM\Column(type="integer")
     */
    public $height;

    /**
     * @var \App\Entity\Frame 지정 받침틀
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Frame")
     */
    public $frame;

}
