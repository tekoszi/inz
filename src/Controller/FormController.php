<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Warehouses;
use App\Entity\History;
use App\Form\ProductType;
# use http\Env\Request;
use function PHPSTORM_META\type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FormController extends AbstractController
{
    /**
     * @Route("/in", name="form")
     */
    # @route było '/form'
    #'action' => $this->generateUrl('form') to było w create form
    public function index(Request $request)
    {

        $warehousesRepository = $this->getDoctrine()
            ->getRepository(Warehouses::class);

        $freespace = $warehousesRepository->findempty();

        foreach ($freespace as &$value) {
            var_dump($value['shelf_id']);
        }

        $product = new Products();
        $form = $this->createForm(ProductType::class, $product,array(
            'attr' =>[
                'freespace' => 'freespace'
                ]
        ));

        $form->handleRequest($request);
         if ($form -> isSubmitted() && $form ->isValid())
         {
             $history = new History();
             $history -> setOperationType('Przyjęcie');
             $history -> setProductName($product->getName());
             $s = date('d/m/Y');
             $date = date_create_from_format('d/m/Y', $s);
             $date->getTimestamp();
             $history -> setOperationDate($date);
             $history -> setProductQuantity($product->getQuantity());
             var_dump($product);
             // Save to DB!
             $em = $this->getDoctrine()->getManager();
             $em ->persist($product);
             $em ->persist($history);
             $em ->flush();

         }
        return $this->render('base.html.twig', [
            'selected_view' => 'form/index.html.twig',
            'controller_name' => 'FormController',
            'product_form' => $form ->createView()
        ]);
    }
}
