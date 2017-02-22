<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Component;

use AppBundle\Form\ComponentType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Ob\HighchartsBundle\Highcharts\Highchart;
class ComponentController extends Controller
{
    /***
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }

    /***
     * @param $dashboardId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addComponentAction($dashboardId)
    {
        $component = new Component();

        $em = $this->getDoctrine()
            ->getManager();

        $component->setDashboard($em->getRepository('AppBundle:Dashboard')->find($dashboardId));

        $em->persist($component);
        $em->flush();

        return $this->redirectToRoute('app_edit_component', array('componentId' => $component->getId()));
    }


    /***
     * @param Request $request
     * @param $componentId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editComponentAction(Request $request, $componentId)
    {
        //Return table and field list (bypass doctrine)
        $conn = $this->get('database_connection');
        $tables = $conn->fetchall('SHOW TABLES');

        foreach($tables as $table)
        {
            foreach($table as $key => $tab)
            {

                //Exclude the Sqldashboard's tables
                if (!($tab == "sqldashboard_component" || $tab == "sqldashboard_dashboard" || $tab == "sqldashboard_user" || $tab == "dashboard_user"))
                {
                    //Display the tables
                    $field = $conn->fetchall('DESCRIBE '.$tab);
                    $listTables[$tab] = $field;
                }
            }
        }

        //Change the head title
        $mainTitle = "Edit component";

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

        //Generate main form
        $form = $this->get('form.factory')->create(new ComponentType, $component);

        if($form->handleRequest($request)->isValid())
        {
            //Change type of chart
            if ($form->get('linechart')->isClicked()) {
                $component->setTypeGraph('linechart');
            }

            if ($form->get('column')->isClicked()) {
                $component->setTypeGraph('column');
            }

            if ($form->get('area')->isClicked()) {
                $component->setTypeGraph('area');
            }

            if ($form->get('bar')->isClicked()) {
                $component->setTypeGraph('bar');
            }

            $em = $this->getDoctrine()
                ->getManager();

            $em->persist($component);
            $em->flush();


            //Reload the page with new data
            return $this->redirect($this->generateUrl('app_edit_component', array(
                'componentId' => $component->getId()
            )));
        }

        return $this->render('AppBundle:App:component.html.twig', array(
            'mainTitle'     => $mainTitle,
            'tables'        => $listTables,
            'form'          => $form->createView(),
            'componentName' => $component->getName(),
            'legend'        => $chart->getLegend(),
            'xAxis'         => $chart->getXAxis(),
            'yAxis'         => $chart->getYAxis(),
            'requestSql'    => $component->getRequestSQL(),
            'chart'         => $chart->generateChart(0),
            'dashboardId'   => $component->getDashboard()
        ));

    }

}