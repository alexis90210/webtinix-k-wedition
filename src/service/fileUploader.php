<?php

namespace App\service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class fileUploader
{

    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory , SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;

    }

    /**
     * @return mixed
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    /**
     * @param mixed $targetDirectory
     */
    public function setTargetDirectory($targetDirectory): void
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function Upload(UploadedFile $file)
    {
        $orignalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($orignalFileName);
        $fileName = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(),$fileName);
            //move_uploaded_file($this->getTargetDirectory(),$fileName);
        }
        catch (FileException $e)
        {
            return $e;
        }
        return $fileName;
    }

}