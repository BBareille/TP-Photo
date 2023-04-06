<?php

namespace App\Controller;
use App\Entity\Photographer;
use App\Entity\User;
use App\Repository\PhotographerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AppController extends AbstractController
{

    public function index(PhotographerRepository $repository): Response
    {
        $mostPopularTag = "Aucun";
        $nbTags = 0;

        if($this->getUser()){
            $userIdentifier = $this->getUser()->getUserIdentifier();
            $nbphoto = $repository->nbOfPhotoByUser($userIdentifier);
            $nbTags = $repository->nbOfTagByUser($userIdentifier);
            $mostPopularFolder = $repository->mostPopularFolder
            ($userIdentifier);
            $mostPopularTag = $repository->mostPopularTag($userIdentifier);
        }

        return $this->render('app/home.html.twig', [
            'statsNbPhoto' => $nbphoto ?? 0,
            'statsNbTags' => $nbTags ?? 0,
            'statsMostPopularFolder' => $mostPopularFolder[0] ?? 'Aucun dossier',
            'statsMostPopularTag' => $mostPopularTag ?? 0
        ]);
    }

    public function navbar(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('app/navbar.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
            ]);
    }

    #[Route('/account', name: 'app_account')]
    public function account(){
        return $this->render('app/account.html.twig');
    }

    #[Route('/BecomePhotographer', name: 'app_setphotographer')]
    public function setPhotographer(UserRepository $repository){
        /** @var User $user */
        $user = $this->getUser();
        $user->setRoles(['ROLE_PHOTO']);
        $repository->save($user, true);

    }
}