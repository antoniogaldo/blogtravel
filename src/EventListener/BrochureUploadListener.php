<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Admin\Articolicategoria;
use App\Service\FileUploader;

class BrochureUploadListener
{
    private $uploader;
    private $fileName;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        // Retrieve Form as Entity
        $entity = $args->getEntity();

        // This logic only works for Product entities
        if (!$entity instanceof Articolicategoria) {
            return;
        }

        // Check which fields were changes
        $changes = $args->getEntityChangeSet();

        // Declare a variable that will contain the name of the previous file, if exists.
        $previousFilename = null;

        // Verify if the brochure field was changed
        if(array_key_exists("image", $changes)){
            // Update previous file name
            $previousFilename = $changes["image"][0];
        }

        // If no new brochure file was uploaded
        if(is_null($entity->getImage())){
            // Let original filename in the entity
            $entity->setImage($previousFilename);

        // If a new brochure was uploaded in the form
        }else{
            // If some previous file exist
            if(!is_null($previousFilename)){
                $pathPreviousFile = $this->uploader->getTargetDirectory(). "/". $previousFilename;

                // Remove it
                if(file_exists($pathPreviousFile)){
                    unlink($pathPreviousFile);
                }
            }

            // Upload new file
            $this->uploadFile($entity);
        }
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Articolicategoria) {
            return;
        }

        $file = $entity->getImage();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);

            $entity->setImage($fileName);
        }
    }
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Articolicategoria) {
            return;
        }

        if ($fileName = $entity->getImage()) {
            $entity->setImage(new File($this->uploader->getTargetDirectory().'/'.$fileName));
        }
    }
}
