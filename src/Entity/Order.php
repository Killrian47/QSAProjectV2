<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Entreprise $entreprise = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isExported = null;

    #[ORM\OneToMany(mappedBy: 'numberOrder', targetEntity: Echantillon::class)]
    private Collection $echantillons;

    public function __construct()
    {
        $this->echantillons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function isIsExported(): ?bool
    {
        return $this->isExported;
    }

    public function setIsExported(?bool $isExported): self
    {
        $this->isExported = $isExported;

        return $this;
    }

    /**
     * @return Collection<int, Echantillon>
     */
    public function getEchantillons(): Collection
    {
        return $this->echantillons;
    }

    public function addEchantillon(Echantillon $echantillon): self
    {
        if (!$this->echantillons->contains($echantillon)) {
            $this->echantillons->add($echantillon);
            $echantillon->setNumberOrder($this);
        }

        return $this;
    }

    public function removeEchantillon(Echantillon $echantillon): self
    {
        if ($this->echantillons->removeElement($echantillon)) {
            // set the owning side to null (unless already changed)
            if ($echantillon->getNumberOrder() === $this) {
                $echantillon->setNumberOrder(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getEntreprise()->getEmail();
    }
}
