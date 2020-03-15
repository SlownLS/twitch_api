<?php 

use SlownLS\Twitch\User;
use SlownLS\Twitch\Channel;

$channelName = "slownls";

if( isset($_GET["channel"]) && !empty($_GET["channel"]) ){
    $channelName = htmlspecialchars($_GET["channel"]);
}

try {
    $channel = new Channel($channelName, TWITCH_CLIENT);
} catch(SlownLS\Twitch\Exception $e){
    echo $e->getMessage();
    exit();
}

$stream = $channel->GetStream();

if( $stream == false ){
    $stream = (object) [];
    $stream->channel = (object) [];
    $stream->channel->status = "Stream offline";
    $stream->game = "Aucun";
    $stream->viewers = 0;
}

User::SetChannel($channel);

?>

<div class="container">
    <div class="text-center mb-5">
        <h1>Welcome to Twitch API</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="">
                <div class="form-group w-100">
                    <input type="text" class="form-control w-100" name="channel" placeholder="Enter twitch channel name.." value="<?= isset($_GET["channel"]) ? $_GET["channel"] : "" ?>">
                </div>
            </form>            
        </div>
    
        <div class="col-md-12 mb-2">
            <h3><?= $stream->channel->status ?></h3>
        </div>

        <div class="col-md-9">
            <iframe 
                frameborder="0" 
                scrolling="no" 
                id="chat_embed" 
                src="https://player.twitch.tv/?channel=<?= $channel->GetName() ?>"
                height="500"
                style="width: 100%"
            ></iframe>
        </div>
        <div class="col-md-3">
            <iframe frameborder="0"
                scrolling="no"
                id="chat_embed"
                src="https://www.twitch.tv/embed/<?= $channel->GetName() ?>/chat"
                height="500"
                style="width: 100%;"
            ></iframe>
        </div>
        <div class="col-md-9">
            <p class="float-left">Category : <?= $stream->game ?></p>
            <p class="float-right">Spectators : <?= $stream->viewers ?></p>
        </div>    
        <div class="col-md-9">
            <?php if(User::IsFollower()): ?>
                <a href="./unfollow?channel=<?= $channelName ?>" class="btn btn-danger btn-sm" style="margin-left: 0;">UnFollow this channel</a>
            <?php else: ?>
                <a href="./follow?channel=<?= $channelName ?>" class="btn btn-success btn-sm" style="margin-left: 0;">Follow this channel</a>
            <?php endif; ?>
        </div>    
    </div>

    
    <?php if( User::IsLogged() ){ ?>
    
    <hr>

    <h3>Your information :</h3>

    <div class="row">
        <div class="col-md-6">
            <p>
                Display name : <?= User::GetLocalInfo("display_name") ?> <br>
                Pseudo : <?= User::GetLocalInfo("name") ?> <br>
                E-mail : <?= User::GetLocalInfo("email") ?> <br>
                Bio : <?= User::GetLocalInfo("bio") ?>
            </p>        
        </div>

        <div class="col-md-6">
            <p>
                You are following <?= $channel->GetDiplayName() ?> : <?= User::IsFollower() == true ? "Yes" : "No" ?> <br>
                You are subscribed to <?= $channel->GetDiplayName() ?> : <?= User::IsSubscriber() == true ? "Yes" : "No" ?> <br>
                You are moderator of <?= $channel->GetDiplayName() ?> : <?= User::IsModerator() == true ? "Yes" : "No" ?> <br>
            </p>        
        </div>        
    </div>

    <?php } ?>
</div>