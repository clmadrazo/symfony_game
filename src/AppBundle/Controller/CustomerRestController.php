<?php

namespace AppBundle\Controller;

use Doctrine\Common\Annotations\Annotation;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Customer\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CustomerRestController extends Controller
{
    /**
     *
     * @ApiDoc(
     * 
     *     section="Students",
     *      resource=true,
     *   description="Get all the students",
     *   parameters={
     *      
     *  }),
     *  statusCodes={
     *         200= "OK",
     *         403= "Returns when authenticated user is not a teacher",
     *         400= "Bad Request"
     *     },
     *  headers={
     *         {
     *             "name"="Authorization",
     *             "description"="Bearer token"
     *         }
     *     }
     *
     * @Route("/api/students.json")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function cgetStudentsAction(){
        
        $students = $this->getDoctrine()->getRepository('AppBundle:Customer')->findBy(array("profile_id" => Customer::PROFILE_ID_STUDENT));
        if($this->getUser()->getProfileId() != Customer::PROFILE_ID_TEACHER)
            throw new HttpException(403, "You are not a teacher.");
        return $students;
    }
    
    /**
     *
     * @ApiDoc(
     *
     *     section="Students",
     *      resource=true,
     *   description="Get a specific student",
     *   requirements={
     *      {
     *          "name"="studentId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Student Id"
     *      }
     *  },
     *   parameters={
     *      
     *  }),
     *  statusCodes={
     *         200="OK",
     *         403= "Returns when authenticated user is not a teacher",
     *         400= "Bad Request",
     *         404={
     *           "Returned when the student is not found"
     *         }
     *     },
     *  headers={
     *         {
     *             "name"="Authorization",
     *             "description"="Bearer token"
     *         }
     *     }
     *
     * @Route("/api/students/studentId.json")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getStudentAction($studentId){
        $customerId = $studentId;
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->findOneById($customerId);
        
        if(!is_object($customer) || $customer->getProfileId() != Customer::PROFILE_ID_STUDENT){
            throw $this->createNotFoundException();
        }
        if($this->getUser()->getProfileId() != Customer::PROFILE_ID_TEACHER){
            throw new HttpException(403, "You are not a teacher.");
        }
        return $customer;
    }
    
    /**
     *
     * @ApiDoc(
     *
     *     section="Students",
     *      resource=true,
     *   description="Get my student info",
     *   parameters={
     *      
     *  }),
     *  statusCodes={
     *         200="OK",
     *         403= "Returns when authenticated user is not a student",
     *         400= "Bad Request"
     *     },
     *  headers={
     *         {
     *             "name"="Authorization",
     *             "description"="Bearer token"
     *         }
     *     }
     *
     * @Route("/api/me.json")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getMeAction(){
        $this->forwardIfNotAuthenticated();
        if($this->getUser()->getProfileId() != Customer::PROFILE_ID_STUDENT)
            throw new HttpException(403, "You are not a student.");
        return $this->getUser();
    }
    
    /**
     *
     * @ApiDoc(
     *
     *     section="Students",
     *      resource=true,
     *   description="Edit my profile",
     *   parameters={
     *      {"name"="studentId", "dataType"="string", "required"=true, "description"="User name"},
     *      {"name"="email", "dataType"="string", "required"=true, "description"="Email"},
     *      {"name"="password", "dataType"="string", "required"=true, "description"="Password"},
     *      {"name"="id", "dataType"="string", "required"=true, "description"="User Id"}
     *  }),
     *  statusCodes={
     *         200="OK",
     *         403= "Returns when authenticated user is not a student",
     *         400= "Bad Request",
     *         404={
     *           "Returned when the student is not found"
     *         }
     *     },
     *  headers={
     *         {
     *             "name"="Authorization",
     *             "description"="Bearer token"
     *         }
     *     }
     *
     * @Route("/api/me.json")
     * @Method("PUT")
     *
     * @return JsonResponse
     */
    public function putMeAction(Request $request){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getEntityManager();
        
        if($this->getUser()->getProfileId() != Customer::PROFILE_ID_STUDENT)
            throw new HttpException(403, "You are not a student.");
        
        $values['username'] = $data->username;
        $values['email'] = $data->email;
        $values['password'] = $data->password;
        $values['id'] = $data->id;
        $values['profile_id'] = Customer::PROFILE_ID_STUDENT;
        
        $customer = $this->getDoctrine()
        ->getRepository('AppBundle:Customer')
        ->findOneById($values['id']);
        if(!is_object($customer)){
            throw $this->createNotFoundException();
        }
        $customer->setUsername($values['username']);
        $customer->setEmail($values['email']);
        $customer->setPassword($values['password']);
        $customer->setProfileId($values['profile_id']);
        
        $em->persist($customer);
        $em->flush();
        return $customer;
    }
    
    /**
     * Shortcut to throw a AccessDeniedException($message) if the user is not authenticated
     * @param String $message The message to display (default:'warn.user.notAuthenticated')
     */
    protected function forwardIfNotAuthenticated($message='warn.user.notAuthenticated'){
        if (!is_object($this->getUser()))
        {
            throw new AccessDeniedException($message);
        }
    }  
    
    /**
     *
     * @ApiDoc(
     *
     *     section="Students",
     *      resource=true,
     *   description="Remove a student",
     *   requirements={
     *      {
     *          "name"="studentId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Student Id"
     *      }
     *  },
     *   parameters={
     *
     *  }),
     *  statusCodes={
     *         204="No Content",
     *         403= "Returns when authenticated user is not a teacher",
     *         400= "Bad Request"
     *         404={
     *           "Returned when the student is not found"
     *         }
     *     },
     *  headers={
     *         {
     *             "name"="Authorization",
     *             "description"="Bearer token"
     *         }
     *     }
     *
     * @Route("/api/students/studentId.json")
     * @Method("DELETE")
     *
     * @return JsonResponse
     */
    public function deleteStudentAction($studentId){
        $em = $this->getDoctrine()->getEntityManager();
        $customer = $em->getRepository('AppBundle:Customer')->find($studentId);
        
        if(!is_object($customer)){
            throw $this->createNotFoundException();
        }
        if($customer->getProfile() != Customer::PROFILE_ID_TEACHER)
            throw new HttpException(403, "You are not a teacher.");
        $em->remove($customer);
        $em->flush();
    }
}
