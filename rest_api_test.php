<?php

/*
 * This script is used to test of opOpenSocialPlugin.
 * (c) Shogo Kawahara <kawahara@bucyou.net>
 */

/* For exapmple
define('CONSUMER_KEY', '0CNRTul3hXdHAmIJ');
define('CONSUMER_SECRET', 'N]k95_LxmPliN1wgjh$ture?DFyA#ZFS');
define('BASE_URL', 'http://op3.happyturn');
*/

define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('BASE_URL', '');

include_once dirname(__FILE__).'/OAuth.php';

$consumer = new OAuthConsumer(CONSUMER_KEY, CONSUMER_SECRET);

$request = OAuthRequest::from_consumer_and_token(
  $consumer,
  null,
  'GET',
  BASE_URL.'/api_prof.php/social/rest/people/@me/@self'
);
$request->set_parameter('xoauth_requestor_id', 1);
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, null);
$res = do_get($request->get_normalized_http_url(), $request->to_postdata());

var_dump("Test1 /people/@me/@self");
var_dump($res);

$request = OAuthRequest::from_consumer_and_token(
  $consumer,
  null,
  'GET',
  BASE_URL.'/api_prof.php/social/rest/people/@me/@friends'
);
$request->set_parameter('xoauth_requestor_id', 1);
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, null);
$res = do_get($request->get_normalized_http_url(), $request->to_postdata());

var_dump("Test2 /people/@me/@friends");
var_dump($res);

function do_get($uri, $data = '')
{
  $h = curl_init();
  curl_setopt($h, CURLOPT_URL, $uri.'?'.$data);
  curl_setopt($h, CURLOPT_POST, false);
  curl_setopt($h, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($h);

  curl_close($h);

  return $result;
}
