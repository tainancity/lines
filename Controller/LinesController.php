<?php

App::uses('AppController', 'Controller');

class LinesController extends AppController {

    public $name = 'Lines';
    public $paginate = array();
    public $helpers = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view', 'json');
        }
    }

    function index() {
        $this->paginate['Line'] = array(
            'limit' => 20,
        );
        $this->set('items', $this->paginate($this->Line));
    }

    function view($id = null) {
        if (!$id || !$this->data = $this->Line->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }
    
    public function json($id = null) {
        if(!empty($id)) {
            $data = $this->Line->read(null, $id);
        }
        if(!empty($data)) {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $data['Line']['json'];
        }
        exit();
    }

    function admin_index() {
        $this->paginate['Line'] = array(
            'limit' => 20,
        );
        $this->set('items', $this->paginate($this->Line));
    }

    function admin_view($id = null) {
        if (!$id || !$this->data = $this->Line->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Line->create();
            if ($this->Line->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Line->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
        $this->set('id', $id);
        $this->data = $this->Line->read(null, $id);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Please do following links in the page', true));
        } else if ($this->Line->delete($id)) {
            $this->Session->setFlash(__('The data has been deleted', true));
        }
        $this->redirect(array('action' => 'index'));
    }

}
