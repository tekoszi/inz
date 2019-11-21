<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShelfsRepository")
 */
class Shelfs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Racks")
     * @ORM\JoinColumn(name="rack_id", referencedColumnName="id")
     */
    private $rack_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRackId(): ?int
    {
        return $this->rack_id;
    }

    public function setRackId(int $rack_id): self
    {
        $this->rack_id = $rack_id;

        return $this;
    }
}
