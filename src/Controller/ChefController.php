<?php

namespace App\Controller;
use App\Entity\Chef;
use App\Entity\Restaurant;
use App\Entity\Food;
use App\Form\ChefType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ChefController extends AbstractController
{
    #[Route('/chef', name: 'app_chef')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $chefs = $doctrine->getRepository('App\Entity\Chef')->findAll();
        return $this->render('chef/chef.html.twig', [
            'chefs' => $chefs,
        ]);
    }
    /**
     * @Route("/chef/create", name="app_create_chef", methods={"GET","POST"})
     */
    public function createAction(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $chef = new Chef();
        $form = $this->createForm(ChefType::class, $chef);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('chefimage')->getData();
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

                // Move the file to the directory where image are stored
                try {
                    $uploadedFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        'Cannot Upload'
                    );
                    // ... handle exception if something happens during file upload
                }
                $chef->setChefimage($newFilename);
                $em = $doctrine->getManager();
                $em->persist($chef);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'New chef added'
                );
                return $this->redirectToRoute('app_create_chef');
            }
        }
        return $this->render('chef/create.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/chef/edit/{id}", name="chef_edit")
     */
    public function editAction(ManagerRegistry $doctrine, int $id, Request $request, SluggerInterface $slugger): Response
    {
        $em = $doctrine->getManager();
        $chef = $em->getRepository(Chef::class)->find($id);

        $form = $this->createForm(ChefType::class, $chef);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('chefimage')->getData();
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

                // Move the file to the directory where image are stored
                try {
                    $uploadedFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        'Cannot Upload'
                    );
                    // ... handle exception if something happens during file upload
                }
            $chef->setChefimage($newFilename);}
            else{
                $this->addFlash(
                    'error',
                    'Cannot upload'
                );
            }
            $em = $doctrine->getManager();
            $em->persist($chef);
            $em->flush();
            return $this->redirectToRoute('app_chef',[
                'id' => $chef->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chef/edit.html.twig', ['form' => $form,'chef'=>$chef]);
    }


    public function saveChanges($form, $request, $chef)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chef->setChefname($request->request->get('chef')['chefname']);
            $chef->setDescriptionChef($request->request->get('chef')['descriptionchef']);
            $chef->setChefimage($request->request->get('chef')['chefimage']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($chef);
            $em->flush();

            return true;
        }

        return false;
    }
    #[Route('/chef/delete/{id}', name: 'app_delete_chef')]
    public function deleteAction(ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $chefs = $em->getRepository(Chef::class)->find($id);

        $em->remove($chefs);
        $em->flush();

        return $this->redirectToRoute('app_chef');
    }
}
