<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Room;
use App\Form\CourseFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    /**
     * @Route("/", name="room")
     */
    public function index(): Response
    {
        return $this->render('room/index.html.twig');
    }

    /**
     * @Route("/room/{room}", name="app_room_detail")
     *
     * @param Room $room
     */
    public function detail(Request $request, Room $room, EntityManagerInterface $manager): Response
    {
        $course = new Course($room);

        $courseForm = $this->createForm(CourseFormType::class, $course);
        $courseForm->handleRequest($request);

        if ($courseForm->isSubmitted()) {
            $course->setRoom($room);
            $manager->persist($course);
            $manager->flush();

            return $this->redirectToRoute('app_room_detail', ['room' => $room->getId()]);
        }

        return $this->render('room/detail.html.twig', [
            'room' => $room,
            'course_form' => $courseForm->createView()
        ]);
    }
}
