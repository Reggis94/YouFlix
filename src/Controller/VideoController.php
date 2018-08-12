<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Video;
use App\Form\AddVideoType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="video")
     */
    public function index()
    {
        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
        ]);
    }
	
	/**
    * @Route("/new-video", name="new-video")
    */
    public function new(Request $request)
    {
		$video = new Video();
		$form = $this->createForm(AddVideoType:: class, $video);
		$form->handleRequest( $request);
		
		if ($form->isSubmitted() && $form->isValid()) {
		 
		 $entityManager = $this->getDoctrine()->getManager();
		 $entityManager ->persist($video);
		 $entityManager ->flush();
		 return $this->redirectToRoute( 'home');
		 }
		 
        return $this->render('video/new-video.html.twig', [
            'form' => $form->createView()
        ]);
    }
	
	/**
    * @Route("/list-my-video", name="list-my-video")
    */
	public function myList(Request $request)
    {
		$repository = $this->getDoctrine()->getRepository(Video::class);

		// look for *all* Product objects
		$videos = $repository->findAll();
		 
        return $this->render('video/my-videos.html.twig', [ 'videos' => $videos]);
    }
	
	/**
    * @Route("/update-video/{id}", name="update_video")
    */
	public function update(Request $request)
    {
		$repository = $this->getDoctrine()->getRepository(Video::class);

		// look for *all* Product objects
		$videos = $repository->findAll();
		 
        return $this->render('video/update-video.html.twig', [ 'videos' => $videos]);
    }
	
	/**
    * @Route("/delete-video/{id}", name="delete_video")
    */
	public function delete(Request $request)
    {
		$entityManager = $this->getDoctrine()->getManager();
		$id = $request->query->get('id');
		$video = $entityManager->getRepository(Video::class)->findOneByUrl($id);
		$entityManager->remove($video);
		$entityManager->flush();
		 
        return $this->redirectToRoute( 'list-my-video');
    }
	
	
}
