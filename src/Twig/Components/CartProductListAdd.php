<?php

namespace App\Twig\Components;

use App\Entity\CartItem;
use App\Entity\Product;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;

#[AsLiveComponent]
class CartProductListAdd
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: true)]
    #[Assert\Positive]
    public int $quantity = 1;

    #[LiveProp]
    public int $productId = 0;

    public function __construct(private ProductRepository $productRepository, private RequestStack $requestStack)
    {
    }

    #[LiveAction]
    public function increase() {
        $this->quantity++;
    }

    #[LiveAction]
    public function decrease() {
        if ($this->quantity < 2)
            return;

        $this->quantity--;
    }
}
