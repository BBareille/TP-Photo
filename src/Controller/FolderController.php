<?php

namespace App\Controller;

use App\Entity\ColorFolder;
use App\Entity\Folder;
use App\Entity\Photographer;
use App\Entity\User;
use App\Form\AddUserToFolderType;
use App\Form\ColorFolderType;
use App\Form\FolderType;
use App\Repository\ClientRepository;
use App\Repository\ColorFolderRepository;
use App\Repository\FolderRepository;
use App\Repository\PhotoRepository;
use App\Service\CheckFolder;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Core\Color;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/folder')]
class FolderController extends AbstractController
{
    public function __construct(private Security $security, private
    CheckFolder $checkFolder)
    {
    }

    #[Route('/', name: 'app_folder_index', methods: ['GET'])]
    public function index(FolderRepository $folderRepository, PhotoRepository $photoRepository): Response
    {
        $folders = $folderRepository->findAll();

        $photo = $photoRepository->findAll();
        return $this->render('folder/index.html.twig', [
            'folders' => $folders,
        ]);
    }

    #[Route('/privateFolder', name: 'app_folder_privatefolder')]
    #[IsGranted('ROLE_USER')]
    public function privateFolder(FolderRepository $folderRepository): Response{
        $folders = $folderRepository->findAll();
        return $this->render('folder/privateFolder.html.twig', [
            'folders' => $folders,
        ]);
    }

    #[IsGranted('ROLE_PHOTO')]
    #[Route('/new', name: 'app_folder_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FolderRepository $folderRepository): Response
    {
        $folder = new Folder();
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $folder->setOwner($this->getUser());
            $folderRepository->save($folder, true);

            return $this->redirectToRoute('app_folder_privatefolder', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('folder/new.html.twig', [
            'folder' => $folder,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_PHOTO')]
    #[Route('/newSubFolder/{id}', name: 'app_folder_addsubfolder')]
    public function addSubFolder(Request $request, $id, FolderRepository $folderRepository){
        $parentFolder = $folderRepository->find($id);
        $folder = new Folder();
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $folder->setParentFolder($parentFolder);
            $folder->setOwner($this->getUser());
            $folderRepository->save($folder, true);
            return $this->redirectToRoute('app_folder_show', ['id' => $id]);
        }

        return $this->render('folder/newSubFolder.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_folder_show', methods: ['GET'])]
    public function show(Folder $folder, PhotoRepository $photoRepository, int $id): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if(!$user || !$this->checkFolder->folderWhereUserIsAllowed($user, $folder)){
            return $this->redirectToRoute('index');
        }


        $photos = $photoRepository->findPhotoByFolder($id);
        return $this->render('folder/show.html.twig', [
            'photos' => $photos,
            'folder' => $folder,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_folder_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Folder $folder, FolderRepository $folderRepository): Response
    {
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $folderRepository->save($folder, true);

            return $this->redirectToRoute('app_folder_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('folder/edit.html.twig', [
            'folder' => $folder,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_folder_delete', methods: ['POST'])]
    public function delete(Folder $folder, FolderRepository $folderRepository): Response
    {
            $folderRepository->remove($folder, true);

        return $this->redirectToRoute('app_folder_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/addAccessTo/{id}', name: 'app_folder_addaccesstouser', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_PHOTO', message: 'Vous n\'êtes pas le propriétaire de ce dossier' , statusCode: 403)]
    public function addAccessToUser(Request $request,Folder $folder,int $id, ClientRepository $clientRepository, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AddUserToFolderType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $userToAdd = $form->get('userToAdd')->getData();
            /** @var Photographer $photographer */
            $photographer = $this->getUser();
            $photographer->addUserToMyPersonalFolder($userToAdd, $folder);
            $em->persist($userToAdd);
            $em->flush();

            return $this->redirectToRoute('app_folder_show', ['id'=>$id]);
        }



        return $this->render('/folder/addUserToFolder.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/colorFolder/{id}', name: 'app_folder_definecolorfolder')]
    public function defineColorFolder(Folder $folder, Request $request, ColorFolderRepository $colorFolderRepository)
    {
        $colorFolder = new ColorFolder();
        $form = $this->createForm(ColorFolderType::class, $colorFolder);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $colorFolder
                ->setOwner($this->getUser())
                ->setParentFolder($folder)
            ;

            $colorFolderRepository->save($colorFolder, true);
        }


        return $this->render('folder/colorFolderForm.html.twig', [
            'form' => $form
        ]);
    }

}
