<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Beer;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/beers", name="beers", methods={"GET"})
     *
     */
    public function beerAction(Request $request)
    {
        $beers = $this->getDoctrine()->getRepository(Beer::class)->findAll();
        foreach ($beers as $beer){
            $beersOk[]= [
                'id'=>$beer->getId(),
                'name'=>$beer->getName(),
                'price'=>$beer->getPrice()
            ];
        }
        return new JsonResponse($beersOk);
    }

    /**
     * @Route("/users", name="users", methods={"GET"})
     *
     */
    public function userAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        foreach ($users as $user){
            $usersOk[]= [
                'id'=>$user->getId(),
                'name'=>$user->getName(),
                'firstname'=>$user->getFirstname(),
                'age'=>$user->getAge()


            ];
        }
        return new JsonResponse($usersOk);
    }

    /**
     * @Route("/addUser", name="addUser", methods={"POST"})
     *
     */
    public function addUserAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName($request->get('name'));
        $user->setFirstname($request->get('firstname'));
        $user->setAge($request->get('age'));
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response("ok");


    }

    /**
     * @Route("/addBeer", name="addBeer", methods={"POST"})
     *
     */
    public function addBeerAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $beer = new Beer();
        $beer->setName($request->get('name'));
        $beer->setPrice($request->get('price'));
        $entityManager->persist($beer);
        $entityManager->flush();
        return new Response("ok");


    }

}
