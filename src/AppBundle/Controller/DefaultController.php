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
     * @Route("/getuser/{id}", name="getuser", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getUserAction($id)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->find($id);

        $userOk=[
            'id'=>$users->getId(),
            'name'=>$users->getName(),
            'firstname'=>$users->getFirstname(),
            'age'=>$users->getAge()
        ];

        return new JsonResponse($userOk);
    }

    /**
     * @Route("/updateuser/{id}", name="updateuser", requirements={"id"="\d+"}, methods={"PUT"})
     *
     */
    public function updateUserAction($id, Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setName($data['name']);
        $user->setFirstName($data['firstname']);
        $user->setAge($data['age']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new Response('update ok');
    }

    /**
     * @Route("/deleteuser/{id}", name="deleteuser", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     */
    public function deleteUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return new Response('remove ok');
    }

    /**
     * @Route("/addUser", name="addUser", methods={"POST"})
     *
     */
    public function addUserAction(Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName($data['name']);
        $user->setFirstname($data['firstname']);
        $user->setAge($data['age']);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('ok');


    }

    /**
     * @Route("/getbeer/{id}", name="getbeer", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getBeerAction($id)
    {
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);

        $beerOk=[
            'id'=>$beer->getId(),
            'name'=>$beer->getName(),
            'price'=>$beer->getPrice()
        ];

        return new JsonResponse($beerOk);
    }

    /**
     * @Route("/addBeer", name="addBeer", methods={"POST"})
     *
     */
    public function addBeerAction(Request $request)
    {

        $data = json_decode($request->getContent(),true);
        $entityManager = $this->getDoctrine()->getManager();
        $beer = new Beer();
        $beer->setName($data['name']);
        $beer->setPrice($data['price']);
        $entityManager->persist($beer);
        $entityManager->flush();
        return new Response('ok');


    }

    /**
     * @Route("/deletebeer/{id}", name="deletebeer", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     */
    public function deleteBeerAction($id)
    {
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($beer);
        $entityManager->flush();

        return new Response('remove ok');
    }

    /**
     * @Route("/updatebeer/{id}", name="updatebeer", requirements={"id"="\d+"}, methods={"PUT"})
     *
     */
    public function updateBeerAction($id, Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);
        $beer->setName($data['name']);
        $beer->setPrice($data['price']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new Response('update ok');
    }

}
