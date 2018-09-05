<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 수목 받침틀
 *
 * @ORM\Entity
 */
class Frame
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
     * @var int 높이
     *
     * @ORM\Column(type="integer")
     */
    public $height;

}
