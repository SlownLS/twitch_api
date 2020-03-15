# twitch_api
A Simple library for Twitch API create in PHP.

## Installation 
To install this library use composer

composer require "slownls/twitch_api"

## User functions

User::IsLogged() - Sert à savoir si l'utilisateur est connecté

User::Logout() - Sert à déconnecter l'utilisateur

User::Login() - Sert à rediriger l'utilisateur sur la page de connection de twitch

User::Connect(string $code) - Sert à connecter l'ulilisateur avec le token twitch

User::GetLocalInfo(string $keu) - Sert à récupérer les informations de l'utilisateur

User::GetByName(string $userName) - Sert à récupérer les informations d'un utilisateur avec son nom


User::SetChannel(\SlownLS\Twitch\Channel $channel) - Sert à définir le channel de référence

User::HasChannel() - Sert à savoir si le channel de référence est définit

User::IsFollower() - Sert à savoir si l'utilisateur suis le channel de référence

User::IsSubscriber() - Sert à savoir si l'utilisateur est abonné au channel de référence

User::IsModerator() - Sert à savoir si l'utilisateur est modérateur du channel de référence

User::FollowChannel() - Sert à suivre le channel de référence

User::UnFollowChannel - Sert à ne plus suivre le channel de référence


## Channel functions

Channel::SetChannel(string $channelName) - Sert à définir la chaine de référence

Channel::HasChannel() - Sert à savoir si le channel de référence est définit

Channel::GetInfos() - Sert à récupérer les informations de la chaine

Channel::GetStream() - Sert à récupérer le stream de la chaine

Channel::GetName() - Sert à récupérer le nom de la chaine

Channel::GetDisplayName() - Sert à récupéré le nom d'affiche de la chaine
