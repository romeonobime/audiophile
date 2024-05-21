<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $shippingCost = null;

    #[ORM\Column]
    private ?int $vatIncludedCost = null;

    #[ORM\Column]
    private ?int $totalCost = null;

    #[ORM\Column]
    private ?int $grandTotalCost = null;

    /**
     * @var Collection<int, CartItem>
     */
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart')]
    private Collection $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
        $this->shippingCost = 50;
        $this->vatIncludedCost = 0;
        $this->totalCost = 0;
        $this->grandTotalCost = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShippingCost(): ?int
    {
        return $this->shippingCost;
    }

    public function setShippingCost(int $shippingCost): static
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    public function getVatIncludedCost(): ?int
    {
        return $this->vatIncludedCost;
    }

    public function setVatIncludedCost(int $vatIncludedCost): static
    {
        $this->vatIncludedCost = $vatIncludedCost;

        return $this;
    }

    public function calculateVatIncludedCost(): void
    {
        $VAT = 20;
        $taxMultiplier = 1 + ($VAT / 100);
        $vats = $this->totalCost * $taxMultiplier;

        $this->setVatIncludedCost($vats - $this->totalCost);
    }

    public function getTotalCost(): ?int
    {
        return $this->totalCost;
    }

    public function setTotalCost(int $totalCost): static
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    public function calculateTotalCost(): void
    {
        $totalCost = 0;

        foreach ($this->getCartItems() as $cartItem) {
            $totalCost += ($cartItem->getProduct()->getPrice() * $cartItem->getQuantity());
        }

        $this->setTotalCost($totalCost);
    }

    public function getGrandTotalCost(): ?int
    {
        return $this->grandTotalCost;
    }

    public function setGrandTotalCost(int $grandTotalCost): static
    {
        $this->grandTotalCost = $grandTotalCost;

        return $this;
    }

    public function calculateGrandTotalCost(): void
    {
        $this->setGrandTotalCost($this->getShippingCost() + $this->getTotalCost());
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): static
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems->add($cartItem);
            $cartItem->setCart($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }

        return $this;
    }
}
