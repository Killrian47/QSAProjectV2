<?php

namespace App\Entity;

use App\Repository\EchantillonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EchantillonRepository::class)]
class Echantillon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'echantillons')]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne(inversedBy: 'echantillons')]
    private ?Order $numberOrder = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $productName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numberLot = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fournisseur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conditionnement = null;

    #[ORM\Column(nullable: true)]
    private ?int $tempProduct = null;

    #[ORM\Column(nullable: true)]
    private ?int $tempEnceinte = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfManufacturing = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DlcDluo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePrelevement = null;

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

    public function getNumberOrder(): ?Order
    {
        return $this->numberOrder;
    }

    public function setNumberOrder(?Order $numberOrder): self
    {
        $this->numberOrder = $numberOrder;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getNumberLot(): ?string
    {
        return $this->numberLot;
    }

    public function setNumberLot(?string $numberLot): self
    {
        $this->numberLot = $numberLot;

        return $this;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?string $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getConditionnement(): ?string
    {
        return $this->conditionnement;
    }

    public function setConditionnement(?string $conditionnement): self
    {
        $this->conditionnement = $conditionnement;

        return $this;
    }

    public function getTempProduct(): ?int
    {
        return $this->tempProduct;
    }

    public function setTempProduct(?int $tempProduct): self
    {
        $this->tempProduct = $tempProduct;

        return $this;
    }

    public function getTempEnceinte(): ?int
    {
        return $this->tempEnceinte;
    }

    public function setTempEnceinte(?int $tempEnceinte): self
    {
        $this->tempEnceinte = $tempEnceinte;

        return $this;
    }

    public function getDateOfManufacturing(): ?\DateTimeInterface
    {
        return $this->dateOfManufacturing;
    }

    public function setDateOfManufacturing(?\DateTimeInterface $dateOfManufacturing): self
    {
        $this->dateOfManufacturing = $dateOfManufacturing;

        return $this;
    }

    public function getDlcDluo(): ?\DateTimeInterface
    {
        return $this->DlcDluo;
    }

    public function setDlcDluo(?\DateTimeInterface $DlcDluo): self
    {
        $this->DlcDluo = $DlcDluo;

        return $this;
    }

    public function getDatePrelevement(): ?\DateTimeInterface
    {
        return $this->datePrelevement;
    }

    public function setDatePrelevement(?\DateTimeInterface $datePrelevement): self
    {
        $this->datePrelevement = $datePrelevement;

        return $this;
    }
}
