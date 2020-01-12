<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RacksRepository")
 */
class Racks
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Rows")
     * @ORM\JoinColumn(name="row_id", referencedColumnName="id")
     */
    private $row_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRowId(): ?int
    {
        return $this->row_id;
    }

    public function setRowId(int $row_id): self
    {
        $this->row_id = $row_id;

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return (string)$this->id;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
