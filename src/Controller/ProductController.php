<?php

namespace App\Controller;

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
                
        $productsForTemplate = $this->prepareProductToDisplay($products);

        return $this->render('product/index.html.twig', [
            'products' => $productsForTemplate,
        ]);
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
            $productTmp['discount'] = $product->getDiscount();

            array_push($productsArray, $productTmp);            
        }

        return $productsArray;
    }
}
