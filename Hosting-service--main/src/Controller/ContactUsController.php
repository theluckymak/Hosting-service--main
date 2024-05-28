<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\ValueObject\ContactForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\FormError;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactUsController extends AbstractController
{
    #[Route('/contact-us', name: 'contactus', methods: ['POST'])]

    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        $successMessage = null;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ContactForm $contactForm */
            $contactForm = $form->getData();

            //TODO: send email

            $email = (new TemplatedEmail())
                ->to('info@cap-coding.com')
                ->from('contactus@cap-coding.com')
                ->subject('it works !!!')
                ->htmlTemplate('emails/contact_form.html.twig')
                ->context([
                    'name' => $contactForm->name,
                    'customer_email' => $contactForm->email,
                    'subject' => $contactForm->subject,
                    'message' => $contactForm->message,
                ]);
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $exception) {
                dump($exception->getMessage());
                $form->addError(new FormError('could not send'));
                $successMessage = 'Message was not sent due to an error.';
            }
        }



        $form = $this->createForm(ContactFormType::class);

        return $this->render('widget/contact_us.twig', [
            'form' => $form,
            'successMessage' => $successMessage,
        ]);
    }
}
