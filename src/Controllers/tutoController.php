<?php

namespace tutoAPI\Controllers;

use DateTime;
use tutoAPI\Models\TutoManager;
use tutoAPI\Models\Tuto;
use tutoAPI\Controllers\abstractController;

class tutoController extends abstractController
{

    public function show($id)
    {

        // Données issues du Modèle

        $manager = new TutoManager();

        $tuto = $manager->find($id);

        // Template issu de la Vue

        return $this->jsonResponse($tuto, 200);
    }

    public function index()
    {

        $tutos = [];

        $manager = new TutoManager();

        $tutos = $manager->findAll();

        return $this->jsonResponse($tutos, 200);
    }

    public function add()
    {

        // Ajout d'un tuto

        $tuto = new Tuto();

        $tuto->setTitle($_POST['title']);
        $tuto->setDescription($_POST['desc']);
        $now=new DateTime();
        $dateString=date('Y-m-d', $now->getTimestamp());
        $tuto->setCreatedAt($dateString);
        $manager = new TutoManager();

        $tuto = $manager->add($tuto);

        

        return $this->jsonResponse($tuto, 200);
    }

    public function patch($id) {
        $manager = new TutoManager();

        $tuto = $manager->find($id);
        parse_str(file_get_contents('php://input'), $_PATCH);
        $tuto->setId($id);
        foreach($_PATCH as $key=>$value) {
            if($key=='title') {
                $tuto->setTitle($value);
            } else if ($key=='desc') {
                $tuto->setDescription($value);
            }
        }
        $manager->update($tuto);
        var_dump($_PATCH);
        die;

    }

    public function delete($id){

        $manager = new TutoManager();
        $tuto = $manager->find($id);
        $manager->delete($tuto);
        return $this->jsonResponse($tuto, 200);
        die();
    }

}
