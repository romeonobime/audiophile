<?php

namespace App\Twig\Components;

use App\Entity\Product;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\ProductRepository;

#[AsTwigComponent]
class PageDetail
{
    private $requestStack;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    public function getSlug()
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentUrl = $request->getUri();
        $explodedUrl = explode("/", $currentUrl);
        $slug = end($explodedUrl);
        return $slug;
    }

    public function getProduct(): ?Product
    {
        $slug = $this->getSlug();
        $product = $this->productRepository->findOneProductBySlug($slug);

        if ( ! $product) {
            // should redirect to a 404 page later.
            throw new NotFoundHttpException('There is no product to be found for this url.');
        }

        return $product;
    }
}
