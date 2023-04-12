<?php

namespace App\Controller;
use App\Entity\Chef;
use App\Entity\Restaurant;
use App\Entity\Food;
use App\Form\FoodType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $foods = $doctrine->getRepository('App\Entity\Food')->findAll();
        $chefs = $doctrine->getRepository('App\Entity\Chef')->findAll();
        $restaurants = $doctrine->getRepository('App\Entity\Restaurant')->findAll();
        return $this->render('review/review.html.twig', [
            'reviews' => $foods,'chefs' => $chefs,'restaurants' => $restaurants,
        ]);
    }

    #[Route('/review/chef/{id}', name: 'app_review_chef')]
    public function AfterAction(ManagerRegistry $doctrine, $id): Response
    {
        $chefs = $doctrine->getRepository('App\Entity\Chef')->find($id);
        $foods = $chefs-> getFood();
        $chefs = $doctrine->getRepository('App\Entity\Chef')->findAll();
        return $this->render('review/review.html.twig', [
            'reviews' => $foods,'chefs' => $chefs,
        ]);
    }
    #[Route('/review/restaurant/{id}', name: 'app_review_restaurant')]
    public function OtherAction(ManagerRegistry $doctrine, $id): Response
    {

        $restaurants = $doctrine->getRepository('App\Entity\Restaurant')->find($id);
        $foods = $restaurants-> getFood();
        $restaurants = $doctrine->getRepository('App\Entity\Restaurant')->findAll();
        return $this->render('review/review.html.twig', [
            'reviews' => $foods,'restaurants' => $restaurants,
        ]);
    }
    /**
     * @Route("/review/create", name="app_create", methods={"GET","POST"})
     */
    public function createAction(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $review = new Food();
        $form = $this->createForm(FoodType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('foodimage')->getData();
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
                $review->setFoodimage($newFilename);
                $em = $doctrine->getManager();
                $em->persist($review);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'New food added'
                );
                return $this->redirectToRoute('app_create');
            }
        }
        return $this->render('review/create.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/review/edit/{id}", name="review_edit")
     */
    public function editAction(ManagerRegistry $doctrine, int $id, Request $request, SluggerInterface $slugger): Response
    {
        $em = $doctrine->getManager();
        $review = $em->getRepository(Food::class)->find($id);

        $form = $this->createForm(FoodType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('foodimage')->getData();
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

                $review->setFoodimage($newFilename);}
                else{
                    $this->addFlash(
                        'error',
                        'Cannot upload'
                    );
                }
                $em = $doctrine->getManager();
                $em->persist($review);
                $em->flush();
                return $this->redirectToRoute('app_review', [
                    'id' => $review->getId()
                ],Response::HTTP_SEE_OTHER ) ;
            }

        return $this->renderForm('review/edit.html.twig', ['form' => $form,'review'=>$review]);
    }


    public function saveChanges($form, $request, $review)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setFoodname($request->request->get('food')['foodname']);
            $review->setDescriptionFood($request->request->get('food')['descriptionfood']);
            $review->setFoodimage($request->request->get('food')['foodimage']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return true;
        }

        return false;
    }
    #[Route('/review/delete/{id}', name: 'app_delete')]
    public function deleteAction(ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $review = $em->getRepository(Food::class)->find($id);

        $em->remove($review);
        $em->flush();

        return $this->redirectToRoute('app_review');
    }

}
