<?php

/*
 * This script is used to test of opOpenSocialPlugin.
 * (c) Shogo Kawahara <kawahara@bucyou.net>
 */

include_once dirname(__FILE__).'/config.php';
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

echo "-----Test1 /people/@me/@self\n";
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

echo "-----Test2 /people/@me/@friends\n";
var_dump($res);

$request = OAuthRequest::from_consumer_and_token(
  $consumer,
  null,
  'GET',
  BASE_URL.'/api_prof.php/social/rest/people/@me/@friends',
  array('filterBy' => 'hasApp')
);
$request->set_parameter('xoauth_requestor_id', 1);
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, null);
$res = do_get($request->get_normalized_http_url(), $request->to_postdata());

echo "-----Test3 /people/@me/@friends?filterBy=hasApp\n";
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
