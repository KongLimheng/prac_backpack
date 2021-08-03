<?php

namespace App\Traits;

trait GetUserLoginTrait
{
    /**
     * Do not change argument
     *
     * @param boolean $contact
     *
     * @return integer
     */

    public function getLoginContactOrUser($contact = true)
    {
        $auth = $this->getInstanceLoginContactOrUser($contact);
        if(!$auth){
            return $auth;
        }

        return $auth->id;
    }
    
    public function getInstanceLoginContactOrUser($contact = true)
    {
        $id = null;

        // Web auth or auth with middleware auth|auth:api
        $auth = optional(\auth::user());

        // auth without inside middleware auth:api but has bearer token
        if(!$auth->id){
            $auth = optional(\Auth::guard('api')->user());
        }

        // if default or guard api false get fallback to check backpack
        if($auth->id){
            $auth = optional(backpack_user());
        }

        // $auth fall to find contact fallback to $id = null
        if($auth->id){
            if($contact){
                return optional($auth->contact);
            }

            return $auth;
        }

        return $id;
    }
}
