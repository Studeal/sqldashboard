<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Components;
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

	public function addComponentAction(Request $request)
	{
		
		//Change the head title
		$mainTitle = "Component creation";

		//Return table and field list (bypass doctrine)
		$conn = $this->get('database_connection');
		$tables = $conn->fetchall('SHOW TABLES');
		foreach($tables as $table)
		{
			foreach($table as $key => $tab)
			{
				// $listTables = $tab;
				$field = $conn->fetchall('DESCRIBE '.$tab);
				$listTables[$tab] = $field;
			}
		}


		//Generate form
		$components = new Components();

		$form = $this->get('form.factory')->create(new ComponentsType, $components);

        if($form->handleRequest($request)->isValid())
        {
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
		'chart'         => $ob,
		'componentName' => "",
		'mainTitle'     => $mainTitle,
        'form'          => $form->createView(),
		'tables'        => $listTables
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