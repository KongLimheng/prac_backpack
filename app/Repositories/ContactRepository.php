<?php

namespace App\Repositories;

use App\Models\Contacts;
use App\Traits\GetUserLoginTrait;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ContactRepository.
 */
class ContactRepository extends BaseRepository
{
    use GetUserLoginTrait;
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Contacts::class;
    }
    public function createContact($user, $request)
    {
        $contact = $this->model->updateOrCreate(
            [
                'owner' => $this->getLoginContactOrUser(),
                'user_id_fk' => $user->id,
                'salutation' => $request->Salutation,
                'first_name' => $request->FirstName,
                'last_name' =>  $request->LastName,
                'email' => $user->email,
                'phone' => $user->phone,
                'profile' => $request->ProfileUser
            ]
        );
    }

    public function updateContact($entry, $request) 
    {
        $contact = $this->model->where('user_id_fk', $entry->id)->first();
        if(!empty($contact)){
            $contact->update(
                [
                    'salutation'=> $request->Salutation,
                    'first_name' => $request->FirstName,
                    'last_name' => $request->LastName,
                    'phone' => $entry->phone,
                    'profile' => $request->ProfileUser,
                ]
            );
        }
        return $contact;
    }
}
