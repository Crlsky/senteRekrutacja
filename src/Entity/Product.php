<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $SKU;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $discount;

    /**
     * @ORM\OneToMany(targetEntity=ProductLang::class, mappedBy="product")
     */
    private $productLangs;

    public function __construct()
    {
        $this->productLangs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSKU(): ?string
    {
        return $this->SKU;
    }

    public function setSKU(string $SKU): self
    {
        $this->SKU = $SKU;

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

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return Collection|ProductLang[]
     */
    public function getProductLangs(): Collection
    {
        return $this->productLangs;
    }

    public function addProductLang(ProductLang $productLang): self
    {
        if (!$this->productLangs->contains($productLang)) {
            $this->productLangs[] = $productLang;
            $productLang->setProduct($this);
        }

        return $this;
    }

    public function removeProductLang(ProductLang $productLang): self
    {
        if ($this->productLangs->removeElement($productLang)) {
            // set the owning side to null (unless already changed)
            if ($productLang->getProduct() === $this) {
                $productLang->setProduct(null);
            }
        }

        return $this;
    }
}
