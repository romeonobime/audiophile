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
class CartDialog
{
    use DefaultActionTrait;

    public function __construct(private RequestStack $requestStack, private ProductRepository $productRepository)
    {
    }

    #[LiveAction]
    public function deleteAllCartItem(): void
    {
        $session = $this->requestStack->getSession();
        $session->remove("cart");
    }

    #[LiveListener("addOneCartItem")]
    public function addOneCartItem(#[LiveArg] int $productId, #[LiveArg] int $quantity): void
    {
        $product = $this->productRepository->findOneBy(["id" => $productId]);
        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);
        $key = $cartItem->getProduct()->getId();

        $session = $this->requestStack->getSession();
        $cart = $session->get("cart", []);
        $cart[$key] = $cartItem;
        $session->set("cart", $cart);
    }

    #[LiveAction]
    public function increase(#[LiveArg] int $key, #[LiveArg] int $quantity): void
    {
        $quantity++;

        $session = $this->requestStack->getSession();
        $cart = $session->get("cart", []);
        $cart[$key]->setQuantity($quantity);
    }

    #[LiveAction]
    public function decrease(#[LiveArg] int $key, #[LiveArg] int $quantity): void
    {
        if ($quantity < 2)
            return;

        $quantity--;

        $session = $this->requestStack->getSession();
        $cart = $session->get("cart", []);
        $cart[$key]->setQuantity($quantity);
    }
}
