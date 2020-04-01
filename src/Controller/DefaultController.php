<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Route\get;
//use App\View\Body;


//Class DefaultController is responsible for all php code

class DefaultController{

    /**
     * @Route("/")
     */
    public function index(){ 

        return new Response(DefaultController::getHtml());
    }

    // Returns a full html response
    private function getHtml(){
        
        $htmlBody = ('<html>
                        <head>
                            <style type="text/css">
                                ul {
                                    list-style:none;
                                    position:relative;
                                    clear: both;
                                }
                                form {
                                    float:left;
                                    padding: 20px;
                                }
                                #bannerimage {
                                    width: 100%;
                                    background-image: url(https://rika.vteximg.com.br/arquivos/ids/270215/marvel02.jpg?v=635578893155400000);
                                    background-position: center;
                                    position:relative;
                                    clear: both;
                                }
                            </style>
                        </head>
                        <body>
                            <!--<div id="bannerimage"/>-->
                            <div>') . 
                                (DefaultController::getSubmitForm()) .
                                (DefaultController::getUpdateForm()) . 
                                (DefaultController::getDeleteForm()) . 
                            ("</div>
                              <div>") .
                                (DefaultController::getElements()) .
                    ("        <div/>
                        <body/>
                    <html/>");

        return ($htmlBody);
    }

    // Form responsable to get Hero name inserted
    private function getSubmitForm(){
        $insertElement = '<form method="POST" action="/insertHero"">
                            <label for="fSuperHero">Insert a Super Hero Name:</label><br>
                            <input type="text" id="fSuperHero" name="fSuperHero">
                            <input type="submit" value="Submit" name="submit"> 
                          </form>';
        return ($insertElement);
    }    

    // Form responsable to update Hero ame
    private function getUpdateForm(){
        $insertElement = '<form method="POST" action="/updateHero" >
                            <label>Insert a number and new name that you want to update:</label><br>
                            <label for="fNumber">Nº</label><br>
                            <input type="number" id="fNumber" name="fNumber"> <br>
                            <label for="fName">Name</label><br>
                            <input type="text" id="fName" name="fName">
                            <input type="submit" value="Submit" name="submit"> 
                          </form>';
        return ($insertElement);
    }  

    // Form responsable to delete one Hero in the list
    private function getDeleteForm(){
        $insertElement = '<form method="POST" action="/deleteHero" >
                            <label>Insert a number of the Hero you want to remove:</label><br>
                            <label for="fNumber">Nº</label><br>
                            <input type="number" id="fNumber" name="fNumber"> <br>
                            <input type="submit" value="Submit" name="submit"> 
                          </form>';
        return ($insertElement);
    }  

    // Returns list of elements (Heros) in the $_SESSION[elements] variable
    private function getElements(){
        $elementList = "<ul>";
        $countElements = 1;
        foreach($_SESSION['elements'] as $element){
            $elementList .= ("<ol>") . ($countElements) . " - ". ($element) . ("</ol>");
            $countElements++;
        }
           
        $elementList .= "</ul>";
        
        return $elementList;
    }

    // After Hero name insertion the form calls a route /insertHero calling this function
    /**
    * @Route("/insertHero")
     */
    public function setElements(){
        if(isset($_POST['submit'])){ // if insertion not null or blanck insert a name on $_SESSION[elements] variable
             array_push($_SESSION['elements'], $_POST['fSuperHero']);
        }
        return new Response($this->getHtml());
    }

    // After values to update a Hero name the form calls a route /updateHero calling this function
    /**
    * @Route("/updateHero")
     */
    public function updateElements(){
        if(isset($_POST['submit'])){
            if(isset($_POST['fNumber']) and isset($_POST['fName'])){
                if($_POST['fNumber'] - 1 >= 0){
                   $_SESSION['elements'][$_POST['fNumber']-1] = $_POST['fName']; // set array position to the element position inserted
                }   
            }
        }
        return new Response($this->getHtml());
    }

    // After insert a position in Hero list the form calls a route /deleteHero calling this function
    /**
    * @Route("/deleteHero")
     */
    public function deleteElements(){
        if(isset($_POST['submit'])){
            if(isset($_POST['fNumber'])){
                if($_POST['fNumber'] - 1 >= 0){
                  unset($_SESSION['elements'][$_POST['fNumber']-1]);//remove element in array
                  $_SESSION['elements'] = array_values($_SESSION['elements']);// re-index the array
                }   
            }
        }
        return new Response($this->getHtml());
    }

}
