var flag_js = true;
var handleScroll = (function(){
    if( (this.scrollY>=1) && (flag_js == true) ){
        flag_js = false;
        // (function(d, s, id) {
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) return;
        //     js = d.createElement(s); js.id = id;
        //     js.src = "https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId="+facebook_app_id+"&autoLogAppEvents=1";
        //     fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        (function() {
            var cx = '015306605513871036558:rq9yjooac5w';
            var gcse = document.createElement('script');
            gcse.type = 'text/javascript';
            gcse.async = true;
            gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(gcse, s);
        })();
    }
    this.removeEventListener("scroll", handleScroll);

});
window.addEventListener("scroll", handleScroll);
var handleMousemove = (function(event){
    x = event.clientX;
    if( (x != -1) && (flag_js == true) ){
        flag_js = false;
        // (function(d, s, id) {
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) return;
        //     js = d.createElement(s); js.id = id;
        //     js.src = "https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId="+facebook_app_id+"&autoLogAppEvents=1";
        //     fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        (function() {
            var cx = '015306605513871036558:rq9yjooac5w';
            var gcse = document.createElement('script');
            gcse.type = 'text/javascript';
            gcse.async = true;
            gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(gcse, s);
        })();
    }
    this.removeEventListener("mousemove", handleMousemove);

});
var x = -1;
document.getElementsByTagName("body")[0].addEventListener("mousemove", handleMousemove);
