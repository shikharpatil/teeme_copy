<?php
/**
 * @date Created on Feb 22, 2011
 * @author		Constantin Bosneaga <ameoba32@gmail.com>
 * 
 */

// Include files

include("Auth/OpenID/Consumer.php");
include("Auth/OpenID/AX.php");
include("Auth/OpenID/google_discovery.php");
include("Auth/OpenID/FileStore.php");
include("Auth/OpenID/SReg.php");
include("Auth/OpenID/PAPE.php");

// Init login
//$tmp = dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR."tmp";
$tmp = $_SERVER['DOCUMENT_ROOT']."/tmp";
if (!file_exists($tmp)) die('Temp path '.$tmp.' does not exists'); 
if (!is_writable($tmp)) die('Temp path '.$tmp.' is not writable');
$config['tmp_path'] = $tmp;

// Return URL
$config['return_server'] = ($_SERVER["HTTPS"]?'https://':'http://').$_SERVER['SERVER_NAME'];

$config['return_url'] = $config['return_server'].'/login_check/check_auth?module=return';


/*https://open.login.yahoo.com/openid/op/start?z=fc0XgxQDD8yv4dsocMiaOf_s8ecqESkAKvfoJJbxAORcl67ZYtbrhj5VCXv9RVxz6EjNX.riQ099gHp3sb3Ft5Uf6ewXrCh3tlMY_STs1r9in0kBqiBQ.ESRpEqUqFhOmOpyQuiGRhBsJRG21zv9Tv.OGq.gU3FSu1heBP7X_vYO7kK8pa.Jbze_G79SZWMwqVgrFRlAgrt21dzFaCulB_UuoUf6Pel0Xy09wySOGtPz_AhRILRSbII5yKzIFxFN8TIla4vLJlKSJAfrYa4rPxPZoNv1wy7ZGmyYCjTsEWlA0m2xQHNsscorYwqAf.ikBW92yW.EwqVUEiGwlHDhOCsN4mhnRtuRa3JH4uhc3959bJnA9Bd7.1sTZwaObhcLz3i7UK5WY9m8o.4B1DXvtSvrNrG4TYvRA1MYWRMT9GxR12mJP1XdIlZEkWOAR4aMhFGl2DluL_mL1TvJLbgCnCIF2yJoV72KaZ4w402TXi02yNR1WgfL_S7DyIMyyraDh6ECGM2HYVPBY.NVljE-*/

// Cache for google discovery (much faster)
$config['cache'] = new FileCache($config['tmp_path']);

// Open id lib has many warnig and notices
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_USER_NOTICE);


switch ($module) {
	
	/**
	 * Process login 
	 */
	case 'login':
		$store = new Auth_OpenID_FileStore($config['tmp_path']);
		$consumer = new Auth_OpenID_Consumer($store);
		new GApps_OpenID_Discovery($consumer, null, $config['cache']);

		try {
			$auth_request = $consumer->begin($domain);
			if (!is_object($auth_request)) die('Auth request object error. Try again');
		} catch (Exception $error) {
			die($error->getMessage());
		}

		/// Request additional parameters
		$ax = new Auth_OpenID_AX_FetchRequest;
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/email',2,1,'email') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/first',1,1, 'firstname') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/last',1,1, 'lastname') );
		
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/friendly',1,1,'friendly') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson',1,1,'fullname') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/birthDate',1,1,'dob') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/person/gender',1,1,'gender') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/postalCode/home',1,1,'postcode') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/country/home',1,1,'country') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/pref/language',1,1,'language') );
		$ax->add( Auth_OpenID_AX_AttrInfo::make('http://axschema.org/pref/timezone',1,1,'timezone') );
		                                                        
		$auth_request->addExtension($ax);

		// Request URL for auth dialog url 
		$redirect_url = $auth_request->redirectURL(
			$config['return_server'],
			$config['return_url']
		);

		if (Auth_OpenID::isFailure($redirect_url)) {
			die('Could not redirect to server: ' . $redirect_url->message);
		} else {
			header('Location: '.$redirect_url);
		}	
	break;
	
	case 'return':
		$store = new Auth_OpenID_FileStore($config['tmp_path']);
		$consumer = new Auth_OpenID_Consumer($store);
		new GApps_OpenID_Discovery($consumer, null, $config['cache']);

		$response = $consumer->complete($req);
echo $response->status;
		// Check the response status.
		if ($response->status == Auth_OpenID_CANCEL) die('Verification cancelled.');
		//if ($response->status == Auth_OpenID_FAILURE) die("OpenID authentication failed: " . $response->message);
		//if ($response->status != Auth_OpenID_SUCCESS) die('Other error');

		// Successful login

		// Extract returned information
		$openid = $response->getDisplayIdentifier();
		$ax = new Auth_OpenID_AX_FetchResponse();
		if ($ax) $ax = $ax->fromSuccessResponse($response);
		
		$sreg = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
		if ($sreg ) $sreg = $sreg->contents();

		# print response
		?>
		<h1>OK</h1>
		You have successfully verified <a href="<?=$openid?>"><?=$openid?></a> as your identity.<br/><br/>
		<p>The following AX response received:</p>
		<pre><?=nl2br(print_r($ax->data,true))?></pre>

		<p>The following sreg response received:</p>
		<pre><?=nl2br(print_r($sreg,true))?></pre>
		<?
	break;	
	
	/**
	 * Return URL, google redirects here after login
	 */
	
}
 
 
class FileCache {
	var $cache_file;

	function __construct($tmp_path) {
		$this->cache_file = $tmp_path.DIRECTORY_SEPARATOR."google.tmp";
	}
	
	function get($name) {
		$cache = unserialize(file_get_contents($this->cache_file));
		return $cache[$name];
	}
	
	function set($name, $value) {
		$cache = unserialize(file_get_contents($this->cache_file));
		$cache[$name] = $value;
		file_put_contents($this->cache_file, serialize($cache));
	}
	
}
 
 
?>
