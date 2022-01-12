<?php

namespace App\Controller;

use App\Form\fileUploaderType;
use App\service\fileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class uploadFileController extends AbstractController
{
    #[Route('/upload', name:'upload')]
     public function index(Request $request, fileUploader $file_uploader, Session $session) : Response
    {
        $form = $this->createForm(fileUploaderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['upload_file']->getData();

           if ($session->get('file') == $file)
           {
               return new Response('fichier deja uploader');
           }
            if ($file)
            {
                $file_name = $file_uploader->upload($file);
                // file as been uploaded , now check public/uploads to see it

                if (null != $file_name)
                {
                    $directory = $file_uploader->getTargetDirectory();
                    $full_path = $directory.'/'. $file_name;
                    $session->set('file',$file);
                    //dd($full_path); // file as been uploaded , now check public/uploads to see it
                }
                else{
                    return new Response('error veuillez reessayer');
                }
            }
        }

        return $this->render('public_template/upload.html.twig',['form'=> $form->createView()]);
    }

}