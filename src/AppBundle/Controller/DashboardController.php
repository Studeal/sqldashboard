<?php
namespace AppBundle\Controller;
use AppBundle\AppBundle;
use AppBundle\Form\DashboardType;
use Doctrine\DBAL\Query\QueryBuilder;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use AppBundle\Entity\Dashboard;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;  //Highcharts bundle
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Component;
use AppBundle\Form\ComponentType;
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
            ->getRepository('AppBundle:Component');
        $components = $repository->findBy(
            array('dashboard' => $id));
        $charts = array();
        $componentName = array();
        $componentId = array();
        $sizeComponent = array();
        $forms = array();
        foreach ($components as $key => $component) {
            $chart = $this->container->get('app.charts');
            $chart->setLegend($component->getLegend());
            $chart->setRequestSql($component->getRequestSQL());
            $chart->setTypeGraph($component->getTypeGraph());
            $chart->setXAxis($component->getXAxis());
            $chart->setYAxis($component->getYAxis());
            $chart = $chart->generateChart($key);
            array_push($charts, $chart);
            array_push($componentName, $component->getName());
            array_push($componentId, $component->getId());
            array_push($sizeComponent, $component->getSizeComponent());
            $forms[$component->getId()] = $this->get('form.factory')->createNamedBuilder($component->getId(), new ComponentType(), $component)->getForm();
        }
        //Get charts service
        $em = $this->getDoctrine()->getManager();
        $dashboard = $em->getRepository('AppBundle:Dashboard')->find($id);
        $form = $this->get('form.factory')->create(new DashboardType(), $dashboard);
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            foreach ($forms as $key => $oneForm) {
                $forms[$key]->handleRequest($request);
            }
            foreach ($forms as $key => $oneForm) {
                if ($oneForm->isSubmitted() && $oneForm->isValid()) {
                    $em = $this->getDoctrine()
                        ->getManager();
                    $component = $em->getRepository('AppBundle:Component')->find($key);
                    if ($oneForm->get('linechart')->isClicked()) {
                        $component->setTypeGraph('linechart');
                    }
                    if ($oneForm->get('column')->isClicked()) {
                        $component->setTypeGraph('column');
                    }
                    if ($oneForm->get('area')->isClicked()) {
                        $component->setTypeGraph('area');
                    }
                    if ($oneForm->get('bar')->isClicked()) {
                        $component->setTypeGraph('bar');
                    }
                    $em->persist($component);
                    $em->flush();
                    return $this->redirectToRoute('app_dashboard', array(
                        'id' => $id,
                        'component' => $component,
                    ));
                }
            }
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($dashboard);
            $em->flush();
            return $this->redirectToRoute('app_dashboard', array(
                'id' => $id));
        }
        foreach ($forms as $key => $formOne) {
            $forms[$key] = $formOne->createView();
        }
        return $this->render('AppBundle:App:dashboard.html.twig', array(
            'allCharts' => $charts,
            'componentName' => $componentName,
            'componentId' => $componentId,
            'dashboard' => $dashboard,
            'components' => $components,
            'id' => $id,
            'form' => $form->createView(),
            'forms' => $forms,
            'size' => $sizeComponent
        ));
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public
    function shareAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $em
            ->getRepository('AppBundle:Dashboard')
            ->find($id);
        $parameter = $request->get('search');
        $listUsers = $em
            ->getRepository('AppBundle:User')
            ->createQueryBuilder('user')
            ->where('user.email LIKE :email')
            ->setParameter('email', '%' . $parameter . '%')
            ->getQuery()
            ->getResult();
//        if form has been submited removes all users from dashboard, adds the checked ones and saves them in the database
        if ($request->get('activeUsers')) {
            $activeUsers = $request->get('activeUsers');
            foreach ($listUsers as $inactiveUser) {
                $dashboard->removeCollaborator($inactiveUser);
                $em->persist($dashboard);
            }
            foreach ($activeUsers as $active) {
                $user = $em->getRepository('AppBundle:User')
                    ->find($active);
                $dashboard->addCollaborator($user);
                $em->persist($dashboard);
            }
            $em->flush();
            return $this->redirectToRoute('app_dashboard', array(
                'id' => $id));
        }
        //pagination
        $users = $this->get('knp_paginator')->paginate($listUsers,
            $this->get('request')->query->get('page', 1), 2/*limit per page*/
        );
        return $this->render('AppBundle:App:shareD.html.twig', array(
            'users' => $users,
            'dashboard' => $dashboard
        ));
    }
    //.......Delete dashboard
    public
    function deleteDashAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $em->getRepository('AppBundle:Dashboard')->find($id);
        if ($dashboard != null) {
            $em->remove($dashboard);
            $em->flush();
        }
        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id));//to do redirect to homepage
    }
    public function changeSizeAction($componentId, $size, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository('AppBundle:Component')->find($componentId);
        $component->setSizeComponent($size);
        $em->persist($component);
        $em->flush();
        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id
        ));
    }
    public function copyComponent($id)
    {
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository('AppBundle:Component')->find($id);
        $em->persist($component);
        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id
        ));
    }
    public function pasteComponentAction($id)
    {
        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id
        ));
    }
}