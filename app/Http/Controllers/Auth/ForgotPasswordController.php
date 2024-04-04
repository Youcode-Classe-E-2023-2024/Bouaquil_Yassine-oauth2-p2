<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Gère la demande d'envoi d'e-mail de réinitialisation de mot de passe pour l'application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request){
        // Valider les données de la requête
        $request->validate(['email'=>'required|email']);

        // Envoyer le lien de réinitialisation de mot de passe via le broker Password
        $response=$this->broker()->sendResetLink(
            $request->only('email')
        );

        // Vérifier si le lien de réinitialisation a été envoyé avec succès ou non
        return $response==Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email.']) // Si réussi
            : response()->json(['message' => 'Unable to send reset link'], 500); // Si échec avec code d'erreur 500
    }

    /**
     * Récupère le broker à utiliser lors de la réinitialisation du mot de passe.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */


    public function broker()
    {
        // Retourne le broker Password pour gérer la réinitialisation du mot de passe
        return Password::broker();
    }

}
