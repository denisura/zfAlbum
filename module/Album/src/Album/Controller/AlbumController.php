<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Form\AlbumForm;
use Doctrine\ORM\EntityManager;
use Album\Entity\Album;

class AlbumController extends AbstractActionController
{

	/**
	 * @var \Album\Entity\Album
	 */
	protected $albumTable;
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
    	return new ViewModel(array(
    			'albums' => $this->getAlbumTable()->findAll(),
    	));
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
    	$form = new AlbumForm();
    	$form->get('submit')->setValue('Add');

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$album = new Album();
    		$form->setInputFilter($album->getInputFilter());
    		$form->setData($request->getPost());

    		if ($form->isValid()) {
    			$album->populate($form->getData());
    			$this->getEntityManager()->persist($album);
    			$this->getEntityManager()->flush();

    			// Redirect to list of albums
    			return $this->redirect()->toRoute('album');
    		}
    	}
    	return array('form' => $form);

    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('album', array(
    				'action' => 'add'
    		));
    	}
    	$album = $this->getEntityManager()->find('Album\Entity\Album', $id);

    	$form  = new AlbumForm();
    	$form->bind($album);
    	$form->get('submit')->setAttribute('value', 'Edit');

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($album->getInputFilter());
    		$form->setData($request->getPost());

    		if ($form->isValid()) {
    			$form->bindValues();
    			$this->getEntityManager()->flush();

    			// Redirect to list of albums
    			return $this->redirect()->toRoute('album');
    		}
    	}

    	return array(
    			'id' => $id,
    			'form' => $form,
    	);
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('album');
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');

    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$album = $this->getEntityManager()->find('Album\Entity\Album', $id);
    			if ($album) {
    				$this->getEntityManager()->remove($album);
    				$this->getEntityManager()->flush();
    			}
    		}

    		// Redirect to list of albums
    		return $this->redirect()->toRoute('album');
    	}

    	return array(
    			'id'    => $id,
    			'album' => $this->getEntityManager()->find('Album\Entity\Album', $id)
    	);
    }

    public function getAlbumTable()
    {
    	if (!$this->albumTable) {
    		$em = $this->getEntityManager();
    		$this->albumTable = $em->getRepository('Album\Entity\Album');
    	}
    	return $this->albumTable;
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function viewAction()
    {
    	$id = (int)$this->params('id');
    	if (!$id) {
    		return $this->redirect()->toRoute('album');
    	}
    	$album = $this->getEntityManager()->find('Album\Entity\Album', $id);
    	return array(
    			'id' => $id,
    			'album' => $album,
    	);
    }
}