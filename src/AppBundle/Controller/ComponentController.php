<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Component;
use AppBundle\Entity\Dashboard;
use AppBundle\Form\ComponentsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;


class ComponentController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }

    public function addComponentAction($dashboardId)
    {
        $component = new Components();
        $em = $this->getDoctrine()
            ->getManager();
        $component->setDashboard($em->getRepository('AppBundle:Dashboard')->find($dashboardId));
        $em->persist($component);
        $em->flush();
        return $this->redirectToRoute('app_edit_component', array('componentId' => $component->getId()));

    }


    //M	ethod for edit a component
    public function editComponentAction(Request $request, $componentId)
    {
        //Return table and field list (bypass doctrine)
        $conn = $this->get('database_connection');
        $tables = $conn->fetchall('SHOW TABLES');
        foreach ($tables as $table) {
            foreach ($table as $key => $tab) {
                // $listTables = $tab;
                $field = $conn->fetchall('DESCRIBE ' . $tab);
                $listTables[$tab] = $field;
            }
        }
        //Get the component in the db
        $repository = $this
            ->getdoctrine()
            ->getManager()
            ->getRepository('AppBundle:Component');
        $component = $repository->find($componentId);
        //Get charts service
        $chart = $this->container->get('app.charts');
        //Set chart
        $chart->setLegend($component->getLegend());
        $chart->setRequestSql($component->getRequestSQL());
        $chart->setTypeGraph($component->getTypeGraph());
        $chart->setXAxis($component->getXAxis());
        $chart->setYAxis($component->getYAxis());
        //Change the head title
        $mainTitle = "Edit component";
        //Generate form
        $form = $this->get('form.factory')->create(new ComponentsType, $component);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            // //We associate the dashboard's id to the chart
            // $component->setDashboards($em->getRepository('AppBundle:Dashboards')->find($component->getDashboards()));

            $em->persist($component);
            $em->flush();
            //Reload the page with
            return $this->redirect($this->generateUrl('app_edit_component', array(
                'componentId' => $component->getId()
            )));
        }
        return $this->render('AppBundle:App:component.html.twig', array(
            'mainTitle' => $mainTitle,
            'tables' => $listTables,
            'form' => $form->createView(),
            'componentName' => $component->getNameComp(),
            'legend' => $chart->getLegend(),
            'xAxis' => $chart->getXAxis(),
            'yAxis' => $chart->getYAxis(),
            'requestSql' => $component->getRequestSQL(),
            'chart' => $chart->generateChart(0)
        ));

    }

}