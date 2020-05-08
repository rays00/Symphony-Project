<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;

class Index extends AbstractController
{
    const UPLOADS_DIR = '/public';
    private $uploadsDir;

    public function __construct(KernelInterface $appKernel)
    {
        $this->uploadsDir = $appKernel->getProjectDir() . self::UPLOADS_DIR;
    }

    public function index($param)
    {
        $finder = new Finder();
        $currentLevelDirectories = [];

        try {
            $finder->depth(0)->in($this->uploadsDir. '/' .$param);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('Not found');
        }

        foreach($finder as $object) {
            if ($object->isDir()) {
                $objectName = $object->getFilenameWithoutExtension();
            } else {
                $objectName = $object->getFilename();
            }
            array_push($currentLevelDirectories, [
                'size' => $object->getSize(),
                'url' => $param. '/' .$objectName,
                'name' => $objectName,
                'last_modified' => gmdate("Y-m-d H:i", $object->getCTime())
            ]);
        }
        return $this->render('index_index.html.twig', [
            'projects' => $currentLevelDirectories
        ]);
    }



}