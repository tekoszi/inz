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


        return $this->render('base.html.twig', [
            'selected_view' => 'form/index.html.twig',
            'controller_name' => 'FormController'
        ]);
    }
}
