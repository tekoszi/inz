<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RowsRepository")
 */
class Rows
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $warehouse_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWarehouseId(): ?int
    {
        return $this->warehouse_id;
    }

    public function setWarehouseId(int $warehouse_id): self
    {
        $this->warehouse_id = $warehouse_id;

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return (string)$this->id;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
