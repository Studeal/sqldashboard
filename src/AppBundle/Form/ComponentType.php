<?php



namespace AppBundle\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;



class ComponentType extends AbstractType

{

    /**

     * {@inheritdoc}

     */

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder

            ->add('name','text')

            ->add('requestSQL','textarea')

            ->add('legend','text')

            ->add('xAxis','text')

            ->add('yAxis','text')

            ->add('Execute',    'submit')

            ->add('column',     'submit')

            ->add('area',       'submit')

            ->add('linechart',  'submit')

            ->add('bar',        'submit');

        ;

    }



    /**

     * {@inheritdoc}

     */

    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'AppBundle\Entity\Component'

        ));

    }



    /**

     * {@inheritdoc}

     */

    public function getBlockPrefix()

    {

        return 'appbundle_component';

    }





}