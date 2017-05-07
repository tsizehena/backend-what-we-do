<?php
/**
 * Created by PhpStorm.
 * User: mazaf
 * Date: 07/05/17
 * Time: 16:36
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Day;

class LoadDayData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $monday = new Day();
        $monday->setDescription('Lundi');
        $manager->persist($monday);

        $tuesday = new Day();
        $tuesday->setDescription('Mardi');
        $manager->persist($tuesday);

        $wednesday = new Day();
        $wednesday->setDescription('Mercredi');
        $manager->persist($wednesday);

        $thursday = new Day();
        $thursday->setDescription('Jeudi');
        $manager->persist($thursday);

        $friday = new Day();
        $friday->setDescription('Vendredi');
        $manager->persist($friday);
        $manager->flush();
    }
}