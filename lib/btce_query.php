<?php
//Using https://btc-e.com/api/documentation
//transfix@sublevels.net 11/30/2013
//11/30/2013 - adding a nonce offset to avoid issues with rapid queries 
//12/23/2013 - adding decode flags
//12/24/2013 - cleaning up a bit

function curl_req($url, $headers = false, $post_data = false, $decode = true)
{
  // our curl handle (initialize if required)
  static $ch = null;
  if(is_null($ch)) 
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; BTCE PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
  }
  curl_setopt($ch, CURLOPT_URL, $url);
  if($post_data != false)
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  if($headers != false)
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
  // run the query
  $res = curl_exec($ch);
  if($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
  if(!$decode) return $res;
  $dec = json_decode($res, true);
  if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
  return $dec;  
}

function btce_query($method, array $req = array(), $decode = true)
{
  // API settings
  $key = getenv("BTCE_KEY"); // your API-key
  if($key === false) throw new Exception('Need to set your API key (env var BTCE_KEY)');
  $secret = getenv("BTCE_SECRET"); // your Secret-key
  if($key === false) throw new Exception('Need to set your secret key (env var BTCE_SECRET)');
 
  $req['method'] = $method;
  $mt = explode(' ', microtime());
  $req['nonce'] = $mt[1];

  static $nonce_offset = 0;
  $req['nonce']+=$nonce_offset;
  $nonce_offset++;
       
  // generate the POST data string
  $post_data = http_build_query($req, '', '&');

  $sign = hash_hmac('sha512', $post_data, $secret);
 
  // generate the extra headers
  $headers = array('Sign: '.$sign,'Key: '.$key);
 
  $url = 'https://btc-e.com/tapi/';
  return curl_req($url, $headers, $post_data, $decode);
}

function btce_btcusd_ticker($decode = true)
{
  $url = 'https://btc-e.com/api/2/btc_usd/ticker';
  return curl_req($url, false, false, $decode);
}

function btce_ltcbtc_ticker($decode = true)
{
  $url = 'https://btc-e.com/api/2/ltc_btc/ticker';
  return curl_req($url, false, false, $decode);
}

function btce_ltcusd_ticker($decode = true)
{
  $url = 'https://btc-e.com/api/2/ltc_usd/ticker';
  return curl_req($url, false, false, $decode);
}

function btce_btcusd_trades($decode = true)
{
  $url = 'https://btc-e.com/api/2/btc_usd/trades';
  return curl_req($url, false, false, $decode);
}

function btce_ltcbtc_trades($decode = true)
{
  $url = 'https://btc-e.com/api/2/ltc_btc/trades';
  return curl_req($url, false, false, $decode);
}

function btce_ltcusd_trades($decode = true)
{
  $url = 'https://btc-e.com/api/2/ltc_usd/trades';
  return curl_req($url, false, false, $decode);
}
 
function btce_btcusd_depth($decode = true)
{
  $url = 'https://btc-e.com/api/2/btc_usd/depth';
  return curl_req($url, false, false, $decode);
}

function btce_ltcbtc_depth($decode = true)
{
  $url = 'https://btc-e.com/api/2/ltc_btc/depth';
  return curl_req($url, false, false, $decode);
}

function btce_ltcusd_depth($decode = true)
{
  $url = 'https://btc-e.com/api/2/ltc_usd/depth';
  return curl_req($url, false, false, $decode);
}

function btce_fee($pair, $decode = true)
{
  $url = "https://btc-e.com/api/2/$pair/fee";
  return curl_req($url, false, false, $decode);
}

?>
