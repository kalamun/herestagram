<?

date_default_timezone_set('America/Los_Angeles');
if(!isset($_GET['from'])) $_GET['from']=0;
if(!isset($_GET['lat'])) die();
if(!isset($_GET['long'])) die();

if(isset($_GET['hub_mode'])&&$_GET['hub_mode']=='subscribe'&&isset($_GET['hub_challenge'])) {
	echo $_GET['hub_challenge'];
	die();
	}

$max_timestamp=$_GET['from']==0?time():$_GET['from'];
$min_timestamp=0;
// get recent images
// Initialize session and set URL.
$url="https://api.instagram.com/v1/media/search?&client_id=".$clientID."&distance=400&lat=".$_GET['lat']."&lng=".$_GET['long']."&max_timestamp=".$max_timestamp."&min_timestamp=".$min_timestamp;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false); // accept any SSL certificate
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); // Set so curl_exec returns the result instead of outputting it.

$response=curl_exec($ch);
curl_close($ch);

$photos=json_decode($response);
if($photos->{'meta'}->{'code'}==200) {
	foreach($photos->{'data'} as $photo) {
		?>
		<div class="photo">
			<a href="<?= $photo->{'link'}; ?>" alt="Open on instagram"><img src="<?= $photo->{'images'}->{'standard_resolution'}->{'url'}; ?>" width="<?= $photo->{'images'}->{'standard_resolution'}->{'width'}; ?>" height="<?= $photo->{'images'}->{'standard_resolution'}->{'height'}; ?>" alt="" /></a>
			<div class="date"><?= strftime("%d %B %Y",$photo->{'created_time'}); ?></div>
			<div class="timestamp"><?= $photo->{'created_time'}; ?></div>
			<h2><?= $photo->{'user'}->{'full_name'}; ?></h2>
			<small><?= $photo->{'user'}->{'username'}; ?></small>
			</div>
		<?
		}
	}
else {
	echo '!';
	echo '<strong>Error '.$photos->{'meta'}->{'code'}.'</strong><br />';
	echo $photos->{'meta'}->{'error_message'};
	}

?>