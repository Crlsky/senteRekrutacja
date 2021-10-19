<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use App\Entity\Lang;
use App\Entity\Product;
use App\Entity\ProductLang;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmExtension;

class ProductImporter extends Fixture
{
    public function load(ObjectManager $manager): void{
        $data = file_get_contents(__DIR__.'/../../public/data.json');
        $data = json_decode($data);
        $lang = $this->insertLang($manager);
        $currency = $this->insertCurrency($manager);

        foreach($data as $product){
            $productObj = $this->insertProduct($product, $manager);
            $this->insertProductLang($product, $productObj, $lang, $manager);
        }

        $manager->flush();
    }

    public function insertProduct(Object $product, ObjectManager $manager): Product{
        $productObj = new Product();
        $productObj->setSKU($product->SKU);
        $productObj->setPrice(floatval($product->price));
        $productObj->setDiscount(intval($product->discount));

        $manager->persist($productObj);

        return $productObj;
    }

    public function insertProductLang(Object $productData, Product $productObj, Lang $lang, ObjectManager $manager): ProductLang{
        $productLang = new ProductLang();
        $productLang->setProduct($productObj);
        $productLang->setName($productData->name);
        $productLang->setDescription($productData->description);
        $productLang->setLang($lang);
        
        $manager->persist($productLang);
   
        return $productLang;
    }

    public function insertLang(ObjectManager $manager): Lang{
        $lang = new Lang();
        $lang->setName('Polski');
        $lang->setIsoCode('pl');

        $manager->persist($lang);

        return $lang;
    }

    public function insertCurrency(ObjectManager $manager): Currency{
        $currency = new Currency();
        $currency->setName('złoty polski');
        $currency->setIsoCode('PLN');
        $currency->setConversionRate(1.0);

        $manager->persist($currency);

        return $currency;
    }
}
