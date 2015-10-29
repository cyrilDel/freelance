<?php

//src/RS/UserBundle/Controller/UserController.php

namespace RS\UserBundle\Controller;



// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class fosuserController extends Controller
{
      public function profileAction(Request $request)
    {  
                    return $this->redirect($this->generateUrl('rs_core_home'));
     
      }
    
    
}