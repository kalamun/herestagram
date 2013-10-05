<!DOCTYPE html>
<html>

<head>
	<title>Herestagram. Discover how people felt the place where you are.</title>
	<meta name="description" content="Discover how people felt the place where you are, on Instagram." />
	<meta name="keywords" content="Instagram, History, Geolocation, Position, Latitude, Longitude, Photos" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
	<meta name="author" content="kalamun.org" />
	<meta name="revisit-after" content="weekly" />
	<meta name="copyright" content="(c) Kalamun GPLv3" />
	<link rel="shortcut icon" href="./img/favicon.ico" />
	<link rel="stylesheet" media="all" href="./css/init.css">
	<link rel="stylesheet" media="all" href="./css/screen.css">
	<script type="text/javascript" src="./js/kalamun.js"></script>
	</head>

<body>
	<div id="container">
		<div id="header">
			<h1><img src="./img/logo.png" width="64" height="64" alt="" /> <strong>Herestagram</strong> photos taken where you are</h1>
			</div>

		<div class="socialsBox"><div id="socials">
			
			<div id="fbButton">
				<div id="fb-root"></div>
				<script>(function(d,s,id) {
					var js,fjs=d.getElementsByTagName(s)[0];
					if(d.getElementById(id)) return;
					js=d.createElement(s); js.id=id;
					js.src="//connect.facebook.net/it_IT/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js,fjs);
					}(document,'script','facebook-jssdk'));</script>
				<div class="fb-like" data-href="http://herestagram.kalamun.org" data-send="false" data-layout="button_count" data-width="91" data-show-faces="false"></div>
				<div class="fb-like bottom" data-href="http://herestagram.kalamun.org" data-send="false" data-layout="button_count" data-width="91" data-show-faces="false"></div>
				<div class="fbCustomLike">I like</div>
				</div>
			<div id="fbShare"><a href="javascript:kPopUp('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]=http%3A%2F%2Fherestagram.kalamun.org',400,300);">Do you really like it? <span class="button">Click here to share</span></a></div>
			<script type="text/javascript">
				var fbTimeout=false;
				function fbMouseOverHandler() {
					if(fbTimeout) {
						clearTimeout(fbTimeout);
						fbTimeout=false;
						}
					fbTimeout=setTimeout(function() {
						document.getElementById('fbShare').style.display='block';
						},500);
					}
				function fbMouseOutHandler() {
					if(fbTimeout) {
						clearTimeout(fbTimeout);
						fbTimeout=false;
						}
					fbTimeout=setTimeout(function() {
						document.getElementById('fbShare').style.display='none';
						},500);
					}
				setTimeout(function() {
					var target=document.getElementById('fbButton').getElementsByTagName('IFRAME')[2];
					if(target) {
						kAddEvent(target,"mouseover",fbMouseOverHandler);
						kAddEvent(target,"mouseout",fbMouseOutHandler);
						}
					var target=document.getElementById('fbShare');
					if(target) {
						kAddEvent(target,"mouseover",fbMouseOverHandler);
						kAddEvent(target,"mouseout",fbMouseOutHandler);
						}
					},2000);
				</script>
			
			<div id="twitterButton">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://herestagram.kalamun.org" data-via="robertopasini" data-lang="it" data-count="horizontal">Tweet</a>
				<a href="https://twitter.com/share" class="twitter-share-button bottom" data-url="http://herestagram.kalamun.org" data-via="robertopasini" data-lang="it" data-count="horizontal">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				<div class="twitterCustomLike">Tweet</div>
				</div>
			
			<div id="plusButton">
				<div class="g-plusone" data-size="tall"></div>
				<div class="bottom"><div class="g-plusone" data-size="medium"></div></div>

				<script type="text/javascript">
				  window.___gcfg = {lang: 'it'};

				  (function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
				<div class="plusCustomLike">+1</div>
				</div>
			
			<div style="clear:both;"></div>
			</div>
		</div>

		<div id="contents">
			</div>
		<div id="loading"></div>

		<script type="text/javascript">
		var aj=new kAjax,kLat=0,kLong=0,kFrom=0;
		var contents=document.getElementById("contents"),
			loading=document.getElementById("loading"),
			isLoading=false;
		
		function loadMore(forceReload) {
			if(isLoading==false||forceReload==true) {
				isLoading=true;
				loading.style.visibility="visible";
				var timestamps=contents.querySelectorAll('.timestamp');
				if(timestamps.length>0) {
					kFrom=parseInt(timestamps[timestamps.length-1].innerHTML)-1000;
					}
				var vars="&lat="+escape(kLat)+"&long="+escape(kLong)+"&from="+escape(kFrom);
				
				aj.onSuccess(printResults);
				aj.send("get","load.php",vars);
				}
			}
		function printResults(html,xml) {
			if(html.substring(0,1)=="!") setTimeout(loadMore,1000,true);
			else {
				isLoading=false;
				contents.innerHTML+=html;
				loading.style.visibility="hidden";
				}
			}
		function getLocation() {
			if(navigator.geolocation) navigator.geolocation.getCurrentPosition(setLocation);
			else contents.innerHTML="Geolocation is not supported by this browser.";
			}
		function setLocation(position) {
			kLat=position.coords.latitude;
			kLong=position.coords.longitude;
			loadMore();
			}

		<?
		if(!isset($_GET['lat'])||!isset($_GET['long'])) { ?>
			getLocation();
			<? }
		else { ?>
			kLat=<?= $_GET['lat']; ?>;
			kLong=<?= $_GET['long']; ?>;
			loadMore();
			<? } ?>
	
		function onScrollHandler() {
			if(!isLoading&&kWindow.scrollTop()>=kWindow.pageHeight()-kWindow.clientHeight()-10) loadMore();
			}
		kAddEvent(window,"scroll",onScrollHandler);
		</script>
		</div>
	</body>
</html>