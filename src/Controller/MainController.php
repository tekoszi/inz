<?php

namespace App\Controller;

use function PHPSTORM_META\type;
use Swift_Message;
use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, \Swift_Mailer $mailer,HistoryRepository $historyRepository)
    {
        $days = '';
        $data = '';
        for ($i = 0; $i <= 6; $i++) {
            $days .= date('Y-m-d', strtotime('-'.$i.'days')).', ';
            $test = $historyRepository->findbydate("'%".date('Y-m-d', strtotime('-'.$i.'days'))."%'");
            $data .= $test[0]['count(*)'].', ';
        }
//        $days = '['.$days.']';
//        $data = '['.$data.']';
//        var_dump($days);

        return $this->render('base.html.twig', [
            'selected_view' => 'main-contener.html.twig',
            'history' => $historyRepository->findAll(),
            'days' => $days,
            'data' => $data

        ]);
    }
}
