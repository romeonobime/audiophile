<?php

namespace App\Entity;

use App\Repository\PaymentDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentDetailRepository::class)]
class PaymentDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isEmoney = null;

    #[ORM\Column]
    private ?bool $isCashOnDelivery = null;

    #[ORM\Column(length: 255)]
    private ?string $eMoneyNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $eMoneyPin = null;

    #[ORM\Column(length: 255)]
    private ?string $paymentMethod = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEmoney(): ?bool
    {
        return $this->isEmoney;
    }

    public function setEmoney(bool $isEmoney): static
    {
        $this->isEmoney = $isEmoney;

        return $this;
    }

    public function isCashOnDelivery(): ?bool
    {
        return $this->isCashOnDelivery;
    }

    public function setCashOnDelivery(bool $isCashOnDelivery): static
    {
        $this->isCashOnDelivery = $isCashOnDelivery;

        return $this;
    }

    public function getEMoneyNumber(): ?string
    {
        return $this->eMoneyNumber;
    }

    public function setEMoneyNumber(string $eMoneyNumber): static
    {
        $this->eMoneyNumber = $eMoneyNumber;

        return $this;
    }

    public function getEMoneyPin(): ?string
    {
        return $this->eMoneyPin;
    }

    public function setEMoneyPin(string $eMoneyPin): static
    {
        $this->eMoneyPin = $eMoneyPin;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
