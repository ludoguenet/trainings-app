<?php

namespace App\Services;

use App\User;
use App\Training;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UserIsAuthorException;
use App\Exceptions\UserIsAlreadySubscribedException;

class TrainingService
{
    public function checkIfUserIsAuthor($training, $user)
    {
        if($training->author == $user->name) {
            throw new UserIsAuthorException('L\'utilisateur est l\'auteur de la formation.');
        }

        return $user;
    }

    public function checkIfUserAlreadySubscribed($training, $user)
    {
        $participant = $training->users->where('id', '=', Auth::user()->id);

        if(!$participant->isEmpty()){
            throw new UserIsAlreadySubscribedException('L\'utilisateur est déjà inscrit à la formation.');
        }
        
        return $user;
    }
}