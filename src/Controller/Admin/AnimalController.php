<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use App\Form\AnimalPhotoType;
use App\Form\AnimalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/animal', name: 'admin_animal_')]
class AnimalController extends AbstractController
{
    #[Route('/edit/{animal_id}', name: 'edit', defaults: ['animal_id' => null])]
    public function manageAnimal(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, string $animal_id = null): Response
    {
        $editMode = false;
        if ($animal_id) {
            $animal = $entityManager->getRepository(Animal::class)->findOneBy(["animal_id" => $animal_id]);
            $editMode = true;

            if (!$animal) {
                throw $this->createNotFoundException('Animal not found');
            }

            $flashMessage = 'Animal updated successfully!';
        } else {
            $animal = new Animal();
            $flashMessage = 'Animal created successfully!';
        }

        $form = $this->createForm(AnimalType::class, $animal);
        $formPhoto = $this->createForm(AnimalPhotoType::class);

        $form->handleRequest($request);
        $formPhoto->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //change "/" to "-"
            $currentAnimalId = $animal->getAnimalId();

            if ($currentAnimalId) {
                $newAnimalId = str_replace('/', '-', $currentAnimalId);
                $animal->setAnimalId($newAnimalId);
            }

            $photo = $formPhoto->get('photo')->getData();
            if ($photo) {
                $year = date('Y');
                $month = date('m');

                $projectDir = $this->getParameter('kernel.project_dir');
                $localDir = '/photos/animals/' . $year . '/' . $month . '/' . $animal->getAnimalId();
                $targetDirectory = $projectDir . '/public' . $localDir;

                $filesystem = new Filesystem();
                try {
                    $filesystem->mkdir($targetDirectory, 0777);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Nie udało się utworzyć katalogu dla zdjęcia.');
                    return $this->redirectToRoute('admin_animal_index');
                }

                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                try {
                    $photo->move($targetDirectory, $newFilename);

                    $imageSize = getimagesize($targetDirectory . '/' . $newFilename);
                    $width = $imageSize[0];
                    $height = $imageSize[1];
                    $fileSize = filesize($targetDirectory . '/' . $newFilename);

                    $animalPhoto = new AnimalPhoto();

                    $animalPhoto->setFilename($localDir . '/' . $newFilename);
                    $animalPhoto->setWidth($width);
                    $animalPhoto->setHeight($height);
                    $animalPhoto->setSize($fileSize);

                    $animalPhoto->setAnimal($animal);

                    $entityManager->persist($animalPhoto);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Nie udało się przenieść zdjęcia.');
                    return $this->redirectToRoute('admin_animal_index');
                }
            }

            $entityManager->persist($animal);
            $entityManager->flush();

            $this->addFlash('success', $flashMessage);

            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/edit.html.twig', [
            'form' => $form->createView(),
            'form_photo' => $formPhoto->createView(),
            'animal' => $animal ?? null,
            'edit_mode' => $editMode,
        ]);
    }

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animals = $entityManager->getRepository(Animal::class)->findAll();

        return $this->render('admin/animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}