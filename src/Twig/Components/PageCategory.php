<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\ProductRepository;

#[AsTwigComponent]
class PageCategory
{
    private $requestStack;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    #[ExposeInTemplate]
    public function getCategory()
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentUrl = $request->getUri();
        $explodedUrl = explode("/", $currentUrl);
        $category = end($explodedUrl);
        return $category;
    }

    #[ExposeInTemplate]
    public function getProducts(): array
    {
        $category = $this->getCategory();
        $products = $this->productRepository->findAllProductByCategory($category);
        $isProductsEmpty = count($products) == 0;

        if ($isProductsEmpty) {
            // should redirect to a 404 page later.
            throw new NotFoundHttpException('There is no products to be found for this url.');
        }

        return $products;
    }
}
