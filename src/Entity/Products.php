<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")z
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Warehouses")
     * @ORM\JoinColumn(name="warehouse_id", referencedColumnName="id")
     */
    private $warehouse_id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Rows")
     * @ORM\JoinColumn(name="row_id", referencedColumnName="id")
     */
    private $row_id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Racks")
     * @ORM\JoinColumn(name="rack_id", referencedColumnName="id")
     */
    private $rack_id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Shelfs")
     * @ORM\JoinColumn(name="shelf_id", referencedColumnName="id")
     */
    private $shelf_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?int
    {
        return $this->barcode;
    }

    public function setBarcode(int $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
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

    public function getRowId(): ?int
    {
        return $this->row_id;
    }

    public function setRowId(int $row_id): self
    {
        $this->row_id = $row_id;

        return $this;
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

    public function getShelfId(): ?int
    {
        return $this->shelf_id;
    }

    public function setShelfId(int $shelf_id): self
    {
        $this->shelf_id = $shelf_id;

        return $this;
    }
}
