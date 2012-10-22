<?php
namespace kosssi\ManagerIrcBotBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IrcServerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('host');
        $builder->add('port');
        $builder->add('channels');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'kosssi\ManagerIrcBotBundle\Entity\IrcServer',
        ));
    }

    public function getName()
    {
        return 'irc_server';
    }
}