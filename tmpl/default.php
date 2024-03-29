<?php
defined( '_JEXEC') or die;?>
<div class="mv-socialbuttons-mod<?php echo $moduleClassSfx;?>">
   <?php if($params->get('showTitle')){ ?>
   <h4><?php echo $params->get('title');?></h4>
   <?php }?>
    <div class="<?php echo $params->get('displayLines');?>">
        <div class="<?php echo $params->get('displayIcons');?>">
        <?php 

        if($params->get("displayMoymir")) {
            echo MvSocialButtonsHelper::getMoymirButton($title, $link, $stylePath);
        }

        if($params->get("displayFacebook")) {
            echo MvSocialButtonsHelper::getFacebookButton($title, $link, $stylePath);
        }

        if($params->get("displayVkcom")) {
            echo MvSocialButtonsHelper::getVkcomButton($title, $link, $stylePath);
        }

        if($params->get("displayLinkedIn")) {
            echo MvSocialButtonsHelper::getLinkedInButton($title, $link, $stylePath);
        }  

        if($params->get("displayTwitter")) {
            echo MvSocialButtonsHelper::getTwitterButton($title, $link, $stylePath);
        }

        if($params->get("displayLivejournal")) {
            echo MvSocialButtonsHelper::getLivejournalButton($title, $link, $stylePath);
        }

        if($params->get("displayGoogle")) {
            echo MvSocialButtonsHelper::getGoogleButton($title, $link, $stylePath);
        }

        if($params->get("displayOdnoklassniki")) {
            echo MvSocialButtonsHelper::getOdnoklassnikiButton($title, $link, $stylePath);
        }
        ?>
        <?php echo MvSocialButtonsHelper::getExtraButtons($title, $link, $params); ?>
        </div>
   </div>
</div>