<?php
// no direct access
defined('_JEXEC') or die;

class MvSocialButtonsHelper{

    public static function getShortUrl($link, $params){    
        JLoader::register("MvSocialButtonsModuleShortUrl", dirname(__FILE__).DIRECTORY_SEPARATOR."shorturl.php");

        $options = array(
            "login"     => $params->get("login"),
            "apiKey"    => $params->get("apiKey"),
            "service"   => $params->get("shortUrlService"),
        );

        $shortUrl  = new MvSocialButtonsModuleShortUrl($link, $options);
        $shortLink = $shortUrl->getUrl();
        if(!$shortLink) {
            // Add logger
            JLog::addLogger(
                array(
                    'text_file' => 'error.php',
                 )
            );
            
            JLog::add($shortUrl->getError(), JLog::ERROR);
            
            // Get original link
            $shortLink = $link;
        } 
        
        return $shortLink;
            
    }
    
    /**
     * Generate a code for the extra buttons. 
     * Is also replace indicators {URL} and {TITLE} with that of the article.
     * 
     * @param string $title Article Title
     * @param string $url   Article URL
     * @param array $params Plugin parameters
     * 
     * @return string
     */
    public static function getExtraButtons($title, $url, &$params) {
        
        $html  = "";
        // Дополнительные кнопки
        for($i=1; $i < 6;$i++) {
            $btnName = "ebuttons" . $i;
            $extraButton = $params->get($btnName, "");
            if(!empty($extraButton)) {
                
                // Parse markup
                if(false !== strpos($extraButton, "<mv:email")) {
                    $matches     = array();
                    if(preg_match('/src="([^"]*)"/i', $extraButton, $matches)) {
                        $extraButton = self::sendToFriendIcon($matches[1], $url);
                    }
                }                
                $extraButton = str_replace("{URL}", $url,$extraButton);
                $extraButton = str_replace("{TITLE}", $title,$extraButton);
                $html  .= $extraButton;
            }
        }        
        return $html;
    }

    public static function sendToFriendIcon($imageSrc, $link) {        
        JLoader::register("MailToHelper", JPATH_SITE . '/components/com_mailto/helpers/mailto.php');        
        $link     = rawurldecode($link);        
		$template = JFactory::getApplication()->getTemplate();
		$url	  = 'index.php?option=com_mailto&tmpl=component&template='.$template.'&link='.MailToHelper::addLink($link);
		$status   = 'width=400,height=350,menubar=yes,resizable=yes';
		$attribs  = array(
		    'title'   => JText::_('JGLOBAL_EMAIL'),
			'onclick' => "window.open(this.href,'win2','".$status."'); return false;"
		);
		$text   = '<img src="'.$imageSrc.'" alt="'. JText::_('MOD_MVSOCIALBUTTONS_SHARE_WITH_FRIENDS').'" title="'. JText::_('MOD_MVSOCIALBUTTONS_SHARE_WITH_FRIENDS').'" />';		
		$output = JHtml::_('link', $url, $text, $attribs);
		return $output;
	} 

    /** Кнопка закладки Facebook. **/ 
    public static function getFacebookButton($title, $link, $style){
        
        $img_url = $style . "/facebook.png";
        
        return '<a rel="noindex, nofollow" href="http://www.facebook.com/sharer.php?u=' . $link . '&amp;t=' . $title . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Facebook") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Facebook") . '" /></a>';
    }

    /** Кнопка закладки Google+. **/    
    public static function getGoogleButton($title, $link, $style){
        
        $img_url = $style . "/googleplus.png";
        
        return '<a rel="noindex, nofollow" href="https://plus.google.com/share?url=' . $link . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Google+") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Google+") . '" /></a>';
    }

    /** Кнопка закладки в Twitter. **/    
    public static function getTwitterButton($title, $link, $style){
        
        $img_url = $style . "/twitter.png";
        
        return '<a rel="noindex, nofollow" href="http://twitter.com/share?text=' . $title . "&amp;url=" . $link . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Twitter") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Twitter") . '" /></a>';
    }

    /** Кнопка закладки Linkedin. **/   
    public static function getLinkedInButton($title, $link, $style){
        
        $img_url = $style . "/linkedin.png";
        
        return '<a rel="noindex, nofollow" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "LinkedIn") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "LinkedIn") . '" /></a>';
    }

    /** Кнопка закладки Живой Журнал. **/       
    public static function getLivejournalButton($title, $link, $style){
        
        $img_url = $style . "/livejournal.png";
        
        return '<a rel="noindex, nofollow" href="http://www.livejournal.com/update.bml?event=' . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Живой Журнал") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Живой Журнал") . '" /></a>';
    }

    /** Кнопка закладки Мой мир. **/   
    public static function getMoymirButton($title, $link, $style){
        
        $img_url = $style . "/moymir.png";
        
        return '<a rel="noindex, nofollow" href="http://connect.mail.ru/share?share_url='  . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Мой мир") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Мой мир") . '" /></a>';
    }

    /** Кнопка закладки Одноклассники. **/       
    public static function getOdnoklassnikiButton($title, $link, $style){
        
        $img_url = $style . "/odnoklassniki.png";
        
        return '<a rel="noindex, nofollow" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st._surl='  . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Одноклассники") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "Одноклассники") . '" /></a>';
    }

    /** Кнопка закладки ВКонтакте. **/    
    public static function getVkcomButton($title, $link, $style){
        
        $img_url = $style . "/vkcom.png";
        
        return '<a rel="noindex, nofollow" href="http://vk.com/share.php?url=' . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "ВКонтакте") . '" target="_blank" onclick="return SocialShare.hardcode(this);"><img src="' . $img_url . '" alt="' . JText::sprintf("MOD_MVSOCIALBUTTONS_SUBMIT", "ВКонтакте") . '" /></a>';
    } 
    
}