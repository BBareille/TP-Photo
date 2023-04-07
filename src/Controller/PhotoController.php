<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Tags;
use App\Form\Photo1Type;
use App\Form\PhotoType;
use App\Repository\FilesRepository;
use App\Repository\FolderRepository;
use App\Repository\PhotoRepository;
use App\Repository\TagsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/photo')]
class PhotoController extends AbstractController
{
    #[Route('/new/{id}', name: 'app_image_new')]
    public function new(Request $request, PhotoRepository $repository, $id, FolderRepository $folderRepository): Response
    {
        $form = $this->createForm(PhotoType::class/*, $photo*/);
        $form->handleRequest($request);
        $folder = $folderRepository->find($id);


        if ($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $photoFile */
            $photoFiles = $form->get('photos')->getData();
            foreach ($photoFiles as $photoFile) {
                $photo = new Photo();
                $photo->setParentFolder($folder);
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . "-" . uniqid() . "." . $photoFile->guessExtension();
                $photo->setSource($newFilename);
                $photo->setDescription('');
                $photo->setName($originalFilename);
                try {
                    $photoFile->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );
                    $repository->save($photo, true);

                } catch (FileException $e) {

                }
            }

            return $this->redirectToRoute('app_folder_show', ['id' => $id]);
        }


        return $this->render('photo/index.html.twig', [
            'form' => $form,
            'controller_name' => 'PhotoController',
        ]);
    }


    #[Route('/{id}/edit', name: 'app_image_edit', methods: ['GET', 'POST'])]
    public function edit($id ,Request $request, Photo $photo, FilesRepository $filesRepository, PhotoRepository $photoRepository): Response
    {
        $form = $this->createForm(Photo1Type::class, $photo);
        $form->handleRequest($request);
        $folder = $filesRepository->findFolderByPhoto($id);


        if ($form->isSubmitted() && $form->isValid()) {
            $photoRepository->save($photo, true);

            return $this->redirectToRoute('app_folder_index',[], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image/edit.html.twig', [
            'folder' => $folder,
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_delete', methods: ['POST'])]
    public function delete(Request $request, Photo $photo, PhotoRepository $photoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->request->get('_token'))) {
            $photoRepository->remove($photo, true);
        }

        return $this->redirectToRoute('app_image_index', [], Response::HTTP_SEE_OTHER);
    }


}
