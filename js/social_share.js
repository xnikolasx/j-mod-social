var SocialShare = {
    vkcom: function(purl, ptitle) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "http://vk.com/share.php",
            url: purl,
            title: ptitle
        }));
    },

    facebook: function(purl, ptitle) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "http://www.facebook.com/sharer.php",
            url: purl,
            title: ptitle,
            url_param: "u",
            title_param: "t",
        }));
    },

    googleplus: function(purl) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "https://plus.google.com/share",
            url: purl,
        }));
    },

    linkedin: function(purl, ptitle) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "http://www.linkedin.com/shareArticle",
            url: purl,
            title: ptitle,
            additional: "mini=true",
        }));
    },

    moymir: function(purl, ptitle) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "http://connect.mail.ru/share",
            url: purl,
            title: ptitle,
            url_param: "share_url",
        }));
    },

    livejournal: function(purl, ptitle) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "http://www.livejournal.com/update.bml",
            url: purl,
            title: ptitle,
            url_param: "event",
        }));
    },

    twitter: function(purl, ptitle) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "http://twitter.com/share",
            url: purl,
            title: ptitle,
            title_param: "text",
        }));
    },

    odnoklassniki: function(purl, ptitle) {
        SocialShare.popup(SocialShare.makeLink({
            social_url: "http://www.odnoklassniki.ru/dk",
            url: purl,
            title: ptitle,
            url_param: "st._surl",
            additional: "st.cmd=addShare",
        }));
    },

    makeLink: function(options) {
        options.url_param = options.url_param || "url";
        options.title_param = options.title_param || "title";

        var url = options.social_url + "?" + options.url_param + "=" + encodeURIcomponent(options.url);
        if(options.title)
            url += "&" + options.title_param + "=" + encodeURIcomponent(options.title);
        if(options.additional)
            url += "&" + options.additional;
        return url;
    },

    hardcode: function(a_link) {
        SocialShare.popup(a_link.href);
        return false;
    },

    popup: function(url) {
        window.open(url,'','toolbar=0,status=0,width=626,height=436');
    }
}