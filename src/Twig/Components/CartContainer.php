<?php

namespace App\Twig\Components;

use App\Entity\Cart;
use App\Entity\CartItem;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
class CartContainer
{
    use DefaultActionTrait;

    public function __construct(private RequestStack $requestStack, private ProductRepository $productRepository)
    {
    }

    #[LiveListener("addOneCartItem")]
    public function addOneCartItem(#[LiveArg] int $productId, #[LiveArg] int $quantity): void
    {
        $product = $this->productRepository->findOneBy(["id" => $productId]);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $session = $this->requestStack->getSession();
        $key = $cartItem->getProduct()->getId();

        $cart = $session->get("cart", new Cart());
        $cart->getCartItems()->set($key, $cartItem);
        $cart->calculateTotalCost();
        $cart->calculateVatIncludedCost();
        $cart->calculateGrandTotalCost();

        $session->set("cart", $cart);
    }

    #[ExposeInTemplate]
    public function getCart(): Cart
    {
        $session = $this->requestStack->getSession();
        return $session->get("cart", new Cart);
    }

    #[LiveAction]
    public function deleteAllCartItem(): void
    {
        $session = $this->requestStack->getSession();
        $session->remove("cart");
    }

    #[LiveAction]
    public function increase(#[LiveArg] int $key, #[LiveArg] int $quantity): void
    {
        $quantity++;

        $session = $this->requestStack->getSession();
        $cart = $session->get("cart", new Cart());
        $cart->getCartItems()->get($key)->setQuantity($quantity);
        $cart->calculateTotalCost();
        $cart->calculateVatIncludedCost();
        $cart->calculateGrandTotalCost();
        $session->set("cart", $cart);
    }

    #[LiveAction]
    public function decrease(#[LiveArg] int $key, #[LiveArg] int $quantity): void
    {
        if ($quantity < 2)
            return;

        $quantity--;

        $session = $this->requestStack->getSession();
        $cart = $session->get("cart", new Cart());
        $cart->getCartItems()->get($key)->setQuantity($quantity);
        $cart->calculateTotalCost();
        $cart->calculateVatIncludedCost();
        $cart->calculateGrandTotalCost();
        $session->set("cart", $cart);
    }
}
