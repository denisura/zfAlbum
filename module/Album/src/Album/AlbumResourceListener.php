<?php
namespace Album;

use Album\Entity\Album;
use PhlyRestfully\Exception\CreationException;
use PhlyRestfully\Exception\UpdateException;
use PhlyRestfully\Exception\PatchException;
use PhlyRestfully\Exception\DomainException;

use PhlyRestfully\ResourceEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation\AnnotationBuilder;

/**
 * Class AlbumResourceListener
 * @package Album
 */
class AlbumResourceListener extends AbstractListenerAggregate
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $persistence;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $entity;

    /**
     * Class constructor
     *
     * @param EntityManager $persistence
     */
    public function __construct(EntityManager $persistence)
    {        
        $this->persistence = $persistence;
        $this->entity = $persistence->getRepository('Album\Entity\Album');
    }

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {     
        $this->listeners[] = $events->attach('create', array($this, 'onCreate'));
        $this->listeners[] = $events->attach('update', array($this, 'onUpdate'));
        $this->listeners[] = $events->attach('replaceList', array($this, 'onReplaceList'));
        $this->listeners[] = $events->attach('patch', array($this, 'onPatch'));
        $this->listeners[] = $events->attach('delete', array($this, 'onDelete'));
        $this->listeners[] = $events->attach('deleteList', array($this, 'onDeleteList'));
        $this->listeners[] = $events->attach('fetch', array($this, 'onFetch'));
        $this->listeners[] = $events->attach('fetchAll', array($this, 'onFetchAll'));
    }

    /**
     * @param ResourceEvent $e
     * @return mixed
     * @throws \PhlyRestfully\Exception\CreationException
     */
    public function onCreate(ResourceEvent $e)
    {
        $builder = new AnnotationBuilder();
        $form = $builder->createForm('Album\Entity\Album');
        $data = $e->getParam('data');
        $data = (array)$data;
        $form->setData($data);
        if (!$form->isValid()) {
            $ex = new CreationException();
            $ex->setDescribedBy('http://example.org/api/errors/user-validation');
            $ex->setTitle('Validation error');
            $ex->setAdditionalDetails($form->getMessages());
            throw $ex;
        }
        $album = new Album();
        $album->populate($form->getData());
        $this->persistence->persist($album);
        $this->persistence->flush();
        return $album;
    }

    /**
     * @param ResourceEvent $e
     * @throws \PhlyRestfully\Exception\UpdateException
     * @return mixed
     */
    public function onUpdate(ResourceEvent $e)
    {
        $builder = new AnnotationBuilder();
        $form = $builder->createForm('Album\Entity\Album');
        $id = $e->getParam('id') ;
        $data = $e->getParam('data');
        $data = (array)$data;
        $album = $this->entity->find($id);
        if (!$album) {
            $ex = new UpdateException("Album [$id] not found.", 404);
            $ex->setDescribedBy('http://example.org/api/errors/user-validation');
            $ex->setTitle('Not found');
            throw $ex;
        }
        $form->bind($album);
        $form->setData($data);
        if (!$form->isValid()) {
            $ex = new UpdateException();
            $ex->setDescribedBy('http://example.org/api/errors/user-validation');
            $ex->setTitle('Validation error');
            $ex->setAdditionalDetails($form->getMessages());
            throw $ex;
        }
        $form->bindValues();
        $this->persistence->flush();
        return $album;
    }

    /**
     * @param ResourceEvent $e
     * @throws \PhlyRestfully\Exception\UpdateException
     */
    public function onReplaceList(ResourceEvent $e)
    {
        $ex = new UpdateException(__METHOD__.' is not implemented', 400);
        $ex->setDescribedBy('http://example.org/api/errors/user-validation');
        $ex->setTitle('Validation error');
        throw $ex;
    }

    /**
     * @param ResourceEvent $e
     * @return mixed
     * @throws \PhlyRestfully\Exception\PatchException
     */
    public function onPatch(ResourceEvent $e)
    {
        $builder = new AnnotationBuilder();
        $form = $builder->createForm('Album\Entity\Album');
        $id = $e->getParam('id') ;
        $data = $e->getParam('data');
        $data = (array)$data;
        $album = $this->entity->find($id);
        if (!$album) {
            $ex = new PatchException("Album [$id] not found.", 404);
            $ex->setDescribedBy('http://example.org/api/errors/user-validation');
            $ex->setTitle('Not found');
            throw $ex;
        }
        $form->bind($album);
        $form->setValidationGroup(array_keys($data));
        $form->setData($data);
        if (!$form->isValid()) {
            $ex = new PatchException();
            $ex->setDescribedBy('http://example.org/api/errors/user-validation');
            $ex->setTitle('Validation error');
            $ex->setAdditionalDetails($form->getMessages());
            throw $ex;
        }
        $form->bindValues();
        $this->persistence->flush();
        return $album;
    }

    public function onFetch(ResourceEvent $e)
    {
        $id = $e->getParam('id');
        $paste = $this->entity->find($id);
        if (!$paste) {
            throw new DomainException('Album not found.'.$id, 404);
        }
        return $paste;
    }

    /**
     * @param ResourceEvent $e
     * @return array
     */
    public function onFetchAll(ResourceEvent $e)
    {
        return $this->entity->findAll();
    }

    /**
     * @param ResourceEvent $e
     * @return bool
     * @throws \PhlyRestfully\Exception\DomainException
     */
    public function onDelete(ResourceEvent $e)
    {
        $id = $e->getParam('id') ;
        $album = $this->entity->find($id);
        if (!$album) {
            $ex = new DomainException("Album [$id] not found.", 404);
            $ex->setDescribedBy('http://example.org/api/errors/user-validation');
            $ex->setTitle('Not found');
            throw $ex;
        }
        $this->persistence->remove($album);
        $this->persistence->flush();
        return true;
    }

    /**
     * @param ResourceEvent $e
     * @return bool
     * @throws \PhlyRestfully\Exception\DomainException
     */
    public function onDeleteList(ResourceEvent $e)
    {
        $albums = $this->entity->findAll();
        if (!$albums) {
            $ex = new DomainException("Albums not found.", 404);
            $ex->setDescribedBy('http://example.org/api/errors/user-validation');
            $ex->setTitle('Not found');
            throw $ex;
        }
        foreach ($albums as $album) {
            $this->persistence->remove($album);
        }
        $this->persistence->flush();
        return true;
    }
}
