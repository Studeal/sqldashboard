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
use Symfony\Component\HttpFoundation\Session\Session;


class DashboardController extends Controller
{

    public function indexAction()
    {
        return $this->render('@App/App/mainPage.html.twig'
        );
    }

    //.......Dashboard view action
    /***
     * @param Request $request
     * @param $dashboard
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Dashboard $dashboard, Request $request)
    {
        //.......Get current logged user
        $user = $this->container->get('security.context')->getToken()->getUser();
        $userId = $user->getId();
        //.......Get current dashboard object
        $em = $this->getDoctrine()->getManager();
        $id = $dashboard->getId();
        if ($dashboard->getCollaborator()->contains($user) || $dashboard->getCreator()== $user) {

            $repository = $this
                ->getdoctrine()
                ->getManager()
                ->getRepository('AppBundle:Component');

            //.......Get current dashboard components
            $components = $repository->findBy(
                array('dashboard' => $id));

            //.......Initialize chart's variables
            $charts = array();
            $componentName = array();
            $componentId = array();
            $sizeComponent = array();
            $forms = array();

            //.......For each component set chart's variables and create a form for each component
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

            //.......Generate form for "Edit Dashboard"
            $form = $this->createForm(new DashboardType(), $dashboard);
            $form->handleRequest($request);

            //.......Check if the method is POST and which form component is submitted
            if ($request->isMethod('POST')) {

                foreach ($forms as $key => $oneForm) {
                    $forms[$key]->handleRequest($request);
                }
                foreach ($forms as $key => $oneForm) {
                    if ($oneForm->isSubmitted() && $oneForm->isValid()) {

                        $em = $this->getDoctrine()
                            ->getManager();
                        $component = $em->getRepository('AppBundle:Component')
                            ->find($key);
                        //.......Change graphic's type
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
                        //.......Save changes made on component
                        $em->persist($component);
                        $em->flush();

                        return $this->redirectToRoute('app_dashboard', array(
                            'id' => $id,
                            'component' => $component,
                        ));
                    }
                }
            }

            //.......If dashboard edit form was submitted, save changes to database
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($dashboard);
                $em->flush();

                return $this->redirectToRoute('app_dashboard', array(
                    'id' => $id));
            }

            //.......Create the view for each component form
            foreach ($forms as $key => $formOne) {
                $forms[$key] = $formOne->createView();
            }
            //.......Render dashboard view and send the variables to it
            return $this->render('AppBundle:App:dashboard.html.twig', array(
                'userId' => $userId,
                'user' => $user,
                'allCharts' => $charts,
                'componentName' => $componentName,
                'componentId' => $componentId,
                'dashboard' => $dashboard,
                'id' => $id,
                'form' => $form->createView(),
                'forms' => $forms,
                'size' => $sizeComponent
            ));
        } else {
            return $this->redirectToRoute('app_home', array(
                'id' => $id));
        }
    }

    //.......Share Dashboard Function
    /***
     * @param Request $request
     * @param $dashboard
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function shareAction(Dashboard $dashboard, Request $request)
    {
        //.......Get current dashboard
        $em = $this->getDoctrine()->getManager();
        $id = $dashboard->getId();
        //.......Get the parameter from url for search function
        $parameter = $request->get('search');
        //.......Get all the user that have in the last name the "value" parameter
        $listUsers = $em
            ->getRepository('AppBundle:User')
            ->createQueryBuilder('user')
            ->where('user.lastName LIKE :lastName')
            ->setParameter('lastName', '%' . $parameter . '%')
            ->getQuery()
            ->getResult();



        //.......if form has been submitted removes all collaborators from dashboard,
        // ......adds the checked ones to the dashboard and saves them in the database
        if ($request->get('activeUsers')) {

            $activeUsers = $request->get('activeUsers');
            $activeCollaborators = $em->getRepository('AppBundle:User')->createQueryBuilder('u')
                ->where('u.id IN (:ids)')
                ->setParameter('ids', $activeUsers)
                ->getQuery()
                ->getResult();

            // remove old collaborators
            foreach ($dashboard->getCollaborator() as $collaborator) {
                if (!in_array($collaborator, $activeCollaborators)) {
                    $dashboard->removeCollaborator($collaborator);
                }
            }
            // add new ones
            foreach ($activeCollaborators as $collaborator) {
                if (!in_array($collaborator, $dashboard->getCollaborator()->toArray())) {
                    $dashboard->addCollaborator($collaborator);
                }
            }
            $em->flush();

            return $this->redirectToRoute('app_dashboard', array(
                'id' => $id));
        }
        //......pagination
        $users = $this->get('knp_paginator')->paginate($listUsers,
            $this->get('request')->query->get('page', 1), 4/*limit per page*/
        );

        return $this->render('AppBundle:App:shareD.html.twig', array(
            'listUsers' => $listUsers,
            'users' => $users,
            'dashboard' => $dashboard
        ));
    }

    //.......Delete dashboard
    /***
     * @param $dashboard
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteDashAction(Dashboard $dashboard)
    {
        //.......Get current dashboard
        $em = $this->getDoctrine()->getManager();
        $id = $dashboard->getId();
        //.......get the components that are on the dashboard
        $components = $em->getRepository('AppBundle:Component')->findBy(
            array('dashboard' => $id));

        //.......delete the components
        //.......delete the dashboard and update database
        if ($dashboard != null) {
            foreach ($components as $component) {
                $em->remove($component);
            }
            $em->remove($dashboard);
            $em->flush();
        }

        return $this->redirectToRoute('app_home', array(
            'id' => $id));
    }

    //.......Leave dashboard function - current user can quit a dashboard where he's been added
    /***
     * @param $dashboard
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function leaveDashAction(Dashboard $dashboard)
    {
        //.......get current user
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        //.......get current dashboard
        $id=$dashboard->getId();
        //.......remove current user from dashboard
        $dashboard->removeCollaborator($user);
        $em->flush();

        return $this->redirectToRoute('app_home', array(
            'id' => $id));//to do redirect to homepage
    }

    //.......Delete Component
    /***
     * @param $componentId
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteComponentAction($componentId, $id)
    {
        //......get component by id
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository('AppBundle:Component')->find($componentId);
        //......delete component
        if ($component != null) {
            $em->remove($component);
            $em->flush();
        }

        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id
        ));
    }
    //.......Change graph size
    /***
     * @param $componentId
     * @param $size
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeSizeAction($componentId, $size, $id)
    {
        //......get current component
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository('AppBundle:Component')->find($componentId);
        //......set component size
        $component->setSizeComponent($size);
        $em->persist($component);
        $em->flush();

        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id
        ));
    }

    //.......Copy Component
    /***
     * @param Request $request
     * @param $componentId
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function copyComponentAction(Request $request, $componentId, $id)
    {
        $session = $request->getSession();
        //......save current component id in the session
        $session->set('idComponent', $componentId);

        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id
        ));
    }

    //.......Paste Component
    /***
     * @param Request $request
     * @param $dashboard
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function pasteComponentAction(Dashboard $dashboard, Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        //......get current dashboard
        $id = $dashboard->getId();
        //......get the id of the component saved in the session inside copy action
        $idComponent = $session->get('idComponent');
        $component = $em->getRepository('AppBundle:Component')->find($idComponent);
        //......clone the component and add it to the dashboard
        $newComponent = clone $component;
        $newComponent->setDashboard($dashboard);
        $em->persist($newComponent);
        $em->flush();

        return $this->redirectToRoute('app_dashboard', array(
            'id' => $id
        ));
    }

}
