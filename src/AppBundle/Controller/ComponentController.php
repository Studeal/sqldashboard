<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\Entity\Components;
use AppBundle\Entity\Dashboards;
use Symfony\Component\HttpFoundation\Request;


class ComponentController extends Controller
{
	
	public function indexAction()
    {
		return $this->render('AppBundle::layout.html.twig');
	}

	public function addComponentAction(Request $request)
	{
		
		//Change the head title
		$mainTitle = "Component creation";

		$dashboards = new Dashboards();
        $components = new Components();

        $form = $this->get('form.factory')->createBuilder('form', $components)
            ->add('nameComp', 'text')
            ->add('Execute', 'submit')
            ->add('requestSQL', 'textarea')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
			$components->setDashboards($dashboards);

            $em = $this->getDoctrine()->getManager();
            $em->persist($components);
			$em->flush();

			return $this->redirect($this->generateUrl('app_add_component', array(
				'id'         => $components->getId(),
				'nameComp'   => $components->getNameComp(),
				'requestSql' => $components->getRequestSQL()
			)));
        }
		
		
		//Factice charts for display
		$series = array(
		array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
		);
		
		
		$ob = new Highchart();
		$ob->chart->renderTo('linechart');
		$ob->title->text('');
		$ob->xAxis->title(array('text'  => "Horizontal axis title"));
		$ob->yAxis->title(array('text'  => "Vertical axis title"));
		$ob->series($series);
		

		return $this->render('AppBundle:App:component.html.twig', array(
		'chart' => $ob,
		'componentName' => "",
		'mainTitle' => $mainTitle,
        'form' => $form->createView()
		));
		
	}
	
	
	//M	ethod for edit a component
	public function editComponentAction($componentId)
	{
		
		//Change the head title
		$mainTitle = "Component edition";
		
		
		//Factice charts
		$series = array(
		array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
		);

		$ob = new Highchart();
		$ob->chart->renderTo('linechart');
		$ob->title->text('');
		$ob->xAxis->title(array('text'  => "Horizontal axis title"));
		$ob->yAxis->title(array('text'  => "Vertical axis title"));
		$ob->series($series);
		

		return $this->render('AppBundle:App:component.html.twig', array(
		'chart'         => $ob,
		'componentName' => "Component name1",
		'mainTitle'     => $mainTitle
		));
		
	}
	
}