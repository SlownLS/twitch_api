# Twitch API
A Simple library for Twitch API create in PHP.

## Installation 
To install this library use composer

composer require "slownls/twitch_api"

## User functions

~~~ php
User::IsLogged() - Whether the user is logged in.

User::Logout() - Used to log the user out.

User::Login() - Used to redirect the user to the twitch login page.

User::Connect(string $code) - Used to connect the user with the twitch token.

User::GetLocalInfo(string $key) - Used to retrieve user's information

User::GetByName(string $userName) - Used to retrieve a user's information with their name.

User::SetChannel(\SlownLS\Twitch\Channel $channel) - Used to set the reference channel

User::HasChannel() - Whether the reference channel is defined

User::IsFollower() - Whether the user is the reference channel.

User::IsSubscriber() - Whether the user subscribes to the reference channel.

User::IsModerator() - Whether the user is the moderator of the reference channel.

User::FollowChannel() - Use to follow the reference channel

User::UnFollowChannel() - Use to no longer follow the reference channel
~~~

## Channel functions

~~~ php
Channel::SetChannel(string $channelName) - Used to set the reference channel

Channel::HasChannel() - Whether the reference channel is defined

Channel::GetInfos() - Used to retrieve the channel information.

Channel::GetStream() - Used to retrieve the stream of the channel

Channel::GetName() - Used to retrieve the name of the channel

Channel::GetDisplayName() - Used to get the channel's poster name.
~~~
