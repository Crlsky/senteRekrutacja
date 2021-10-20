<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product")
     */
    public function index(): Response{
        return $this->redirectToRoute('productList',[
            'limit' => 50,
            'page' => 1
        ]);
    }

    /**
     * @Route("/product/{limit}/{page}", name="productList")
     */
    public function productList(int $limit, int $page): Response{
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findByLimit($limit, $page);
                
        $numberOfPages = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findNumberOfPages($limit);

        $productsForTemplate = $this->prepareProductToDisplay($products);

        return $this->render('product/index.html.twig', [
            'products' => $productsForTemplate,
            'currency' => $this->getCurrency(),
            'currentLimit' => $limit,
            'productPerPageLimits' => $this->getProductPerPageLimit(),
            'pagination'    => $this->getPagination($page),
            'numberOfPages' => $numberOfPages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @Route("/search/{searchTerm}", name="search", methods={"GET"})
     */
    public function searchProduct(string $searchTerm): Response{
        $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findSeachProduct($searchTerm);
        
        $productForAjax = $this->prepareProductToDisplay($products);

        return new Response(json_encode($productForAjax));
    }

    // if u need more languages u need to change a way of selecting name and description
    public function prepareProductToDisplay(array $products): array{
        $productsArray = [];
        foreach($products as $key => $product){
            $productTmp['id'] = $product->getId();
            $productTmp['sku'] = $product->getSKU();
            $productTmp['name'] = $product->getProductLangs()->first()->getName();
            $productTmp['description'] = $product->getProductLangs()->first()->getDescription();
            $productTmp['price'] = $product->getPrice();
            $productTmp['discount'] = $this->calculateDiscount($productTmp['price'], $product->getDiscount());

            array_push($productsArray, $productTmp);            
        }

        return $productsArray;
    }

    public function getCurrency(){
        $currency = $this->getDoctrine()
                    ->getRepository(Currency::class)
                    ->find(1)
                    ->getIsoCode();
        return $currency;
    }

    public function calculateDiscount(float $price, int $discount): float{
        if($discount === 0)
            return 0;

        return round($price-($price*($discount/100)),2);
    }

    public function getProductPerPageLimit(): array {
        $limitArray = [25, 50, 100];

        return $limitArray;
    }

    public function getPagination(int $currentPage = 1): array {
        $paginationArray = [];

        for($i = $currentPage; $i <= $currentPage+3; $i++)
            array_push($paginationArray, $i);

        return $paginationArray;
    }
}
