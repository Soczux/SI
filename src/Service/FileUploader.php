<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $songTargetDirectory;
    private $albumTargetDirectory;

    /**
     * @param $albumTargetDirectory
     * @param $songTargetDirectory
     */
    public function __construct($albumTargetDirectory, $songTargetDirectory)
    {
        $this->albumTargetDirectory = $albumTargetDirectory;
        $this->songTargetDirectory = $songTargetDirectory;
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function uploadSong(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getSongTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function uploadAlbum(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getAlbumTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    /**
     * @return mixed
     */
    public function getSongTargetDirectory()
    {
        return $this->songTargetDirectory;
    }

    /**
     * @return mixed
     */
    public function getAlbumTargetDirectory()
    {
        return $this->albumTargetDirectory;
    }
}
