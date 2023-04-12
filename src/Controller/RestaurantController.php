<?php

namespace App\Controller;
use App\Entity\Chef;
use App\Entity\Restaurant;
use App\Entity\Food;
use App\Form\RestaurantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant', name: 'app_restaurant')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $restaurants = $doctrine->getRepository('App\Entity\Restaurant')->findAll();
        return $this->render('restaurant/restaurant.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }
    /**
     * @Route("/restaurant/create", name="app_create_restaurant", methods={"GET","POST"})
     */
    public function createAction(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $restaurants = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurants);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('restaurantimage')->getData();
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
                $restaurants->setRestaurantimage($newFilename);
                $em = $doctrine->getManager();
                $em->persist($restaurants);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'New restaurant added'
                );
                return $this->redirectToRoute('app_create_restaurant');
            }
        }
        return $this->render('restaurant/create.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/restaurant/edit/{id}", name="restaurant_edit")
     */
    public function editAction(ManagerRegistry $doctrine, int $id, Request $request,SluggerInterface $slugger): Response
    {
        $em = $doctrine->getManager();
        $restaurants = $em->getRepository(Restaurant::class)->find($id);

        $form = $this->createForm(RestaurantType::class, $restaurants);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('restaurantimage')->getData();
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
                $restaurants->setRestaurantimage($newFilename);}
            else{
                    $this->addFlash(
                        'error',
                        'Cannot upload'
                    );
                }
            $em = $doctrine->getManager();
            $em->persist($restaurants);
            $em->flush();
            return $this->redirectToRoute('app_restaurant',[
                'id' => $restaurant->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/edit.html.twig', ['form' => $form,'restaurant'=>$restaurants]);
    }


    public function saveChanges($form, $request, $restaurants)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurants->setRestaurantname($request->request->get('restaurant')['restaurantname']);
            $restaurants->setDescriptionRestaurant($request->request->get('restaurant')['descriptionrestaurant']);
            $restaurants->setRestaurantimage($request->request->get('restaurant')['restaurantimage']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurants);
            $em->flush();

            return true;
        }

        return false;
    }
    #[Route('/restaurant/delete/{id}', name: 'app_delete_restaurant')]
    public function deleteAction(ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $restaurants = $em->getRepository(Restaurant::class)->find($id);

        $em->remove($restaurants);
        $em->flush();

        return $this->redirectToRoute('app_restaurant');
    }
}
