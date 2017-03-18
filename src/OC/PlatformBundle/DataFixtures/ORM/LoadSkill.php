<?php
/**
 * Created by PhpStorm.
 * User: Punis_Port
 * Date: 18/03/2017
 * Time: 18:40
 */

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Skill;

class LoadSkill implements FixtureInterface
{
    public function load(ObjectManager $manager){
        $names = array(
            'PHP',
            'Symfony',
            'C++',
            'Java',
            'Photshop',
            'Blender',
            'Bloc-notes'
        );

        foreach ($names as $name){
            $skill = new Skill();
            $skill->setName($name);
            $manager->persist($skill);
        }

        $manager->flush();
    }
}