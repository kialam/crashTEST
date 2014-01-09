<!DOCTYPE html>
<!--
Crash the super bowl app - voting with thismoment and facebook integration
-->
<html>
    <head>
        <title>Doritos Crash the Super Bowl.</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="css/reset.css" />
        <style>
            
            .container { max-width: 810px; height: 142px; }
            .ctsModules { width: 99%; padding: 1% 1% 1% 0; }
            .ctsHeader { width: 100%; height: 39px; margin: 0 auto; margin-top: -8px; background: url(images/bg-head.png) center center scroll no-repeat; 
                            -moz-transition:opacity .5s;
                            -webkit-transition:opacity .5s;
                            -o-transition:opacity .5s;
                            transition:opacity .5s; }
            .ctsModulesContainer { width: 100%; margin-top: 7px; 
                            -moz-transition:opacity .5s;
                            -webkit-transition:opacity .5s;
                            -o-transition:opacity .5s;
                            transition:opacity .5s;
                            text-align: center; }
            .ctsModulesContainer p { text-align: center; vertical-align: central; margin-top: 15px; }
            .ctsModule { display: inline-block; margin: 0 5px 9px; position: relative; }
            .ctsThumbnail { width: 147px; height: 87px; position: relative; top: 5px; left: 5px; -webkit-filter: grayscale(50%); -moz-filter: grayscale(50%); -ms-filter: grayscale(50%); -o-filter: grayscale(50%); filter: grayscale(50%); }
            .ctsThumbnailOverlay { width: 157px; height: 98px; position: absolute; top: 0; left: 0; background: url(images/border.png) scroll no-repeat; }
            .ctsThumbnailOverlay:hover { -webkit-filter: invert(50%); -moz-filter: invert(50%); -ms-filter: invert(50%); -o-filter: invert(50%); filter: invert(50%); }
            
            .thanks { background: url(images/thanks.png) scroll no-repeat; opacity: 0; background-size: contain; }
            .hidden { opacity: 0;  }
            .show { opacity: 1; }
            
            .hovered { -webkit-filter: grayscale(0%); -moz-filter: grayscale(0%); -ms-filter: grayscale(0%); -o-filter: grayscale(0%); filter: grayscale(0%); }
            .clear { clear: both; }
            
            body { overflow:hidden; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="ctsModules">
                <div class="ctsHeader"></div>
                <div class="ctsModulesContainer">
                    
                    <?php
                    
                        $videos = array(
                            array(
                                'name' => 'Office Thief',
                                'content_id' => '14400',
                                'link' => 'https://www.youtube.com/watch?v=oMdwJ7fyp00&amp;feature=youtube_gdata_player',
                                'thumbnail' => 'images/office.png'
                            ),
                            array(
                                'name' => 'Breakroom',
                                'content_id' => '14399',
                                'link' => 'https://www.youtube.com/watch?v=MoANeCLWOjI&amp;feature=youtube_gdata_player',
                                'thumbnail' => 'images/ostrich.png'
                            ),
                            array(
                                'name' => 'Finger',
                                'content_id' => '14398',
                                'link' => 'https://www.youtube.com/watch?v=ugo7Y2lRsxc&amp;feature=youtube_gdata_player',
                                'thumbnail' => 'images/finger.png'
                            ),
                            array(
                                'name' => 'Time',
                                'content_id' => '14397',
                                'link' => 'https://www.youtube.com/watch?v=Y-P0Hs0ADJY&amp;feature=youtube_gdata_player',
                                'thumbnail' => 'images/time.png'
                            ),
                            array(
                                'name' => 'Cowboy',
                                'content_id' => '14396',
                                'link' => 'https://www.youtube.com/watch?v=FHY5pwgCY3w&amp;feature=youtube_gdata_player',
                                'thumbnail' => 'images/cowboy.png'
                            )
                        );
                        
                        shuffle($videos);
                        foreach($videos as $video) {
                            echo apply_template($video);
                        }
                        
                        function apply_template($video) {
                            $cid = $video['content_id'];
                            $link = $video['link'];
                            $t = $video['thumbnail'];
                            $template = <<<TEMPLATE
                                <div class="ctsModule">
                                    <a class="ctsVote" href="#" data-contentid="$cid" data-link="$link">
                                        <img class="ctsThumbnail" src="$t" alt="thumbnail">
                                        <div class="ctsThumbnailOverlay"></div>
                                    </a>                            
                                </div>
TEMPLATE;
                            return $template;
                        }
                        
                        
                    ?>
                    
                    <div class="clear"></div></div>
            </div>
        </div>
        
    <div id="fb-root"></div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
    <script>
        window.fbAsyncInit = function() {
            
            // globals
            var CTS_ENVIRONMENT_PRODUCTION = (window.location.href.search('localhost.com') == -1),
                CTS_GALLERY_ID = 5,
                CTS_ENVIRONMENT = 0;
        
            var CTS = {};
            
            // init
            CTS.facebookAppId = setAppId(CTS_ENVIRONMENT_PRODUCTION);
            CTS.facebookVoteActionUrl = setVoteUrl(CTS_ENVIRONMENT_PRODUCTION);
            CTS.facebookChannelUrl = setChannelUrl(CTS_ENVIRONMENT_PRODUCTION);
            
            setApp(CTS_ENVIRONMENT, CTS_GALLERY_ID, function(data) {
                CTS.app = data;
                console.log(CTS);
            });
            
            FB.init({
                appId: CTS.facebookAppId,
                status: true,
                xfbml: true,
                cookie: true,
                oauth: true,
                channelUrl: CTS.facebookChannelUrl
            });
            

            FB.Event.subscribe('auth.authResponseChange', function(response) {
    // Here we specify what we do with the response anytime this event occurs. 
    if (response.status === 'connected') {
      // The response object is returned with a status field that lets the app know the current
      // login status of the person. In this case, we're handling the situation where they 
      // have logged in to the app.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // In this case, the person is logged into Facebook, but not into the app, so we call
      // FB.login() to prompt them to do so. 
      // In real-life usage, you wouldn't want to immediately prompt someone to login 
      // like this, for two reasons:
      // (1) JavaScript created popup windows are blocked by most browsers unless they 
      // result from direct interaction from people using the app (such as a mouse click)
      // (2) it is a bad experience to be continually prompted to login upon page load.
      FB.login();
    } else {
      // In this case, the person is not logged into Facebook, so we call the login() 
      // function to prompt them to do so. Note that at this stage there is no indication
      // of whether they are logged into the app. If they aren't then they'll see the Login
      // dialog right after they log in to Facebook. 
      // The same caveats as above apply to the FB.login() call here.
      FB.login();
    }
  });

            // events
            $('.ctsModules').on('click', '.ctsVote', handleVoteClick);
            $('.ctsModules').on('mouseover', '.ctsThumbnailOverlay', handleHoverOver);
            $('.ctsModules').on('mouseout', '.ctsThumbnailOverlay', handleHoverOff);
            
            // helpers
            function setAppId(productionEnvironment) {
                if(productionEnvironment) {
                    return '380688338665036';
                }
                return '317973431658835';
            }
            
            function setVoteUrl(productionEnvironment) {
                if(productionEnvironment) {
                    return '/me/crashthesuperbowl:vote';
                }
                return '/me/boldstagefollower:vote';
            }
            
            function setChannelUrl(productionEnvironment) {
                if(productionEnvironment) {
                    return 'https://sslwork.goodbysilverstein.com/crash2013/channel.html';
                }
                return 'http://localhost.com/channel.html';
            }
            
            function setApp(env, gid, callback) {
                $.getJSON('get.json.php', {environment: env, gallery_id: gid}, callback);
            }
            
            function handleVoteClick(evt) {
                // get the data
                evt.preventDefault();
                var videoUrl = $(this).data('link');
                console.log(videoUrl);
                var contentId = $(this).data('contentid');
                console.log(contentId);
                
                // check to make sure user is logged into facebook    
                FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                var uid = response.authResponse.userID;
                //console.log(uid);
                var accessToken = response.authResponse.accessToken;
                //console.log(accessToken);
                    //console.log('success!');

                // execute the vote and display the "thanks" banner
                thisMomentHandleVote(contentId);
                testAPI();                
                } 
                // if user is not authorized, display fb login window
                else if (response.status === 'not_authorized') {
                    FB.login();
                    console.log('not logged in');
                } 
                // if user is not logged in, display fb login window
                else {
                    FB.login();
                    console.log('logged in and clicked')
                    }
                });
                
                
                
                
                // return contentId;
                // thismoment
                //thisMomentHandleVote(contentId);
                // console.log(thisMomentHandleVote);
                
                // deal with facebook the old fashioned way
                // FB.api('me/permissions','get',function(perms) {
                //     console.log(perms)
                //     if(perms.data[0].publish_actions) {
                //         facebookHandleVote(CTS, videoUrl);
                //     } else {
                //         console.log(perms);
                //     }     
                // });

                FB.api('/me/permissions', function (response) {
                    //return response;
                    //console.log(response);
                    if (response.error) {
                    console.log('Error - ' + response.error.message);
                    return
                }   
            var perms = response.data[0];
            console.log(perms);
            // Check for publish_stream permission in this case....
            if (perms.publish_stream) {                
                // User has permission
                facebookHandleVote(CTS, videoUrl);
            } else {                
                // User DOESN'T have permission. Perhaps ask for them again with FB.login?
                console.log('no permission');
                facebookHandleVote(CTS, videoUrl);
            }                                            
            });
            }
            
            function shuffle(array) {
                var currentIndex = array.length,
                    temporaryValue,
                    randomIndex;

                // While there remain elements to shuffle...
                while (0 !== currentIndex) {

                    // Pick a remaining element...
                    randomIndex = Math.floor(Math.random() * currentIndex);
                    currentIndex -= 1;

                    // And swap it with the current element.
                    temporaryValue = array[currentIndex];
                    array[currentIndex] = array[randomIndex];
                    array[randomIndex] = temporaryValue;
                }

                return array;
            }    
            
            function handleHoverOver() {
                $(this).siblings('.ctsThumbnail').addClass('hovered');
            }
            
            function handleHoverOff() {
                $(this).siblings('.ctsThumbnail').removeClass('hovered');
            }
            
            function thisMomentHandleVote(cid) {
//                https://www.doritos.com/v4/api/content/vote.json - new 
//                https://doritoscrashthesuperbowl.thismoment.com/v4/api/content/vote.json - old
                var url = 'https://www.doritos.com/v4/api/content/vote.json';
                $.getJSON(url, {
                    content_id: cid
                }, function(data) {
                    console.log(data);
                    if(data.status == 'OK') {
                        // thanks for voting
//                        $('.ctsModules').html('<img src="images/thanks.png" alt="Thanks!" />');
                        $('.ctsModules').addClass('thanks');
                        $('.ctsHeader').addClass('hidden');
                        $('.ctsModulesContainer').addClass('hidden');
                        $('.ctsModules').addClass('show');
                        setTimeout(function() {
                            $('.ctsModules').css({
                                // 'width': '810px',
                                'height': '142px'
                            });
                            $('.ctsHeader').remove();
                            $('.ctsModulesContainer').remove();
                        }, 1000);
                    } else {
                        // no vote
                        console.log('no vote cast');
                    }   
                });
            }
            
            function facebookHandleVote(cts, videoUrl) {
                FB.api(cts.facebookVoteActionUrl, 'post', { other: videoUrl }, function(response) {
                    if(!response || response.error) {
                        console.log(response)
                    } else {
                        console.log(response)
                        
                    }
                });
            }
            
        };

        // Load the SDK asynchronously
        (function(){
            if (document.getElementById('facebook-jssdk')) {return;}
            var firstScriptElement = document.getElementsByTagName('script')[0];
            var facebookJS = document.createElement('script'); 
            facebookJS.id = 'facebook-jssdk';
            facebookJS.src = '//connect.facebook.net/en_US/all.js';
            firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
         }());
    </script>
    <!-- <fb:login-button show-faces="true" width="200" max-rows="1"></fb:login-button> -->
    </body>
</html>
