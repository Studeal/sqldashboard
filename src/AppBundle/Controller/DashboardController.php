<?php

namespace AppBundle\Controller;


use AppBundle\AppBundle;
use AppBundle\Form\DashboardsType;
use Doctrine\DBAL\Query\QueryBuilder;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use AppBundle\Entity\Dashboards;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;  //Highcharts bundle
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Components;


class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }


    public function viewAction(Request $request, $id)
    {
        $repository = $this
            ->getdoctrine()
            ->getManager()
            ->getRepository('AppBundle:Components');
        $components = $repository->findBy(
            array('dashboards' => $id));

        $charts = array();
        $componentsName = array();
        $componentsId = array();

        foreach ($components as $key => $component) {
            $chart = $this->container->get('app.charts');
            $chart->setLegend($component->getLegend());
            $chart->setRequestSql($component->getRequestSQL());
            $chart->setTypeGraph($component->getTypeGraph());
            $chart->setXAxis($component->getXAxis());
            $chart->setYAxis($component->getYAxis());
            $chart = $chart->generateChart($key);
            array_push($charts, $chart);
            array_push($componentsName, $component->getNameComp());
            array_push($componentsId, $component->getId());
        }

        //Get charts service

        $em = $this->getDoctrine()->getManager();
        $dashboard = $em->getRepository('AppBundle:Dashboards')->find($id);


        $form = $this->get('form.factory')->create(new DashboardsType(), $dashboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($dashboard);
            $em->flush();

            return $this->redirectToRoute('app_home', array(
                'id' => $id));
        }

        return $this->render('AppBundle:App:dashboard.html.twig', array(
            'allCharts' => $charts,
            'componentsName' => $componentsName,
            'componentsId' => $componentsId,
            'dashboards' => $dashboard,
            'id' => $id,
            'form' => $form->createView()
        ));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function shareAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboards = $em
            ->getRepository('AppBundle:Dashboards')
            ->find($id);

        $parameter = $request->get('search');

        $listUsers = $em
            ->getRepository('AppBundle:User')->createQueryBuilder('user')
            ->where('user.username LIKE :username')
            ->setParameter('username', '%' . $parameter . '%')
            ->getQuery()
            ->getResult();


//        if form has been submited removes all users from dashboard, adds the checked ones and saves them in the database

        if ($request->get('activeUsers')) {
            $activeUsers = $request->get('activeUsers');

            foreach ($listUsers as $inactiveUser) {
                $inactiveUser->removeDashboard($dashboards);
                $em->persist($inactiveUser);
            }

            foreach ($activeUsers as $active) {
                $user = $em->getRepository('AppBundle:User')
                    ->find($active);
                $user->addDashboard($dashboards);
                $em->persist($user);
            }

            $em->flush();

            return $this->redirectToRoute('app_home', array(
                'id' => $id));
        }
        //pagination
        $users = $this->get('knp_paginator')->paginate($listUsers,
            $this->get('request')->query->get('page', 1), 2/*limit per page*/
        );

        return $this->render('AppBundle:App:shareD.html.twig', array(

            'users' => $users,
            'dashboard' => $dashboards
        ));
    }

    //.......Delete dashboard
    public function deleteDashAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $em->getRepository('AppBundle:Dashboards')->find($id);

        if ($dashboard != null) {
            $em->remove($dashboard);
            $em->flush();
        }

        return $this->redirectToRoute('app_home', array(
            'id' => $id));//to do redirect to homepage
    }

}
