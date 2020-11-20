<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/player")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="player_index", methods={"GET"})
     */
    public function index(): Response
    {
        $players = $this->getDoctrine()
            ->getRepository(Player::class)
            ->findAll();

        return $this->render('player/index.html.twig', [
            'players' => $players,
        ]);
    }

    /**
     * @Route("/topdix", name="player_top10", methods={"GET"})
     */
    public function topDix(): Response
    {
        $players = $this->getDoctrine()
            ->getRepository(Player::class)
            ->findBy(array(),array('ratio' => 'DESC'));

            return $this->render('player/top.html.twig', [
                'players' => $players,
            ]);
    }

      /**
     * @Route("/one/{username}", name="oneplayer", methods={"GET"})
     */
    public function findByUsername($username)
    {
        $players = $this->getDoctrine()
            ->getRepository(Player::class)
            ->findOneBy(array('username' => $username));
        $joueur = new Player();
        $joueur->setUsername($players->getUsername());
        $joueur->setRatio($players->getRatio());
        return $joueur;
    }

    /**
     * @Route("/principal", name="principal", methods={"GET"})
     */
    public function goToPrincipal(): Response
    {
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $username = $user->getUsername();
        $player = $this->findByUsername($username);
        return $this->render('player/principal.html.twig', [
            'player' => $player,
        ]);
    }

    /**
     * @Route("/new", name="player_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player->setPassword($encoder->encodePassword($player, $player->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('player_index');
        }

        return $this->render('player/new.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_show", methods={"GET"})
     */
    public function show(Player $player): Response
    {
        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="player_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Player $player): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_index');
        }

        return $this->render('player/edit.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Player $player): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($player);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_index');
    }
}
