<?php

namespace App\Entity;

use App\Repository\LangRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LangRepository::class)
 */
class Lang
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iso_code;

    /**
     * @ORM\OneToMany(targetEntity=ProductLang::class, mappedBy="lang")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsoCode(): ?string
    {
        return $this->iso_code;
    }

    public function setIsoCode(string $iso_code): self
    {
        $this->iso_code = $iso_code;

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
            $productLang->setLang($this);
        }

        return $this;
    }

    public function removeProductLang(ProductLang $productLang): self
    {
        if ($this->productLangs->removeElement($productLang)) {
            // set the owning side to null (unless already changed)
            if ($productLang->getLang() === $this) {
                $productLang->setLang(null);
            }
        }

        return $this;
    }
}
