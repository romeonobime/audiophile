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
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
class CartProductList
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    public function __construct(private RequestStack $requestStack, private ProductRepository $productRepository)
    {
    }

    #[ExposeInTemplate]
    public function getCartItems()
    {
        $session = $this->requestStack->getSession();
        return $session->get("cart", []);
    }

}
