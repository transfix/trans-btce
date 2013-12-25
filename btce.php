<?php

//Command line btc-e interface.
//transfix@sublevels.net 12/21/2013

require_once('lib/lib.php');

if(!isset($argv[1]))
  {
    echo "Usage: ".$argv[0]." <command> <command args>\n";
    exit(1);
  }

$command = $argv[1];

try 
{
  if($command === "balance")
    {
      if(!isset($argv[2])) throw new Exception("balance <currency>");
      $currency = $argv[2];
      echo btce_balance($currency)."\n"; 
    }
  else if($command === "server_time")
    {
      echo date("D M j G:i:s T Y",btce_server_time())."\n"; 
    }
  else if($command === "ticker")
    {
      if(!isset($argv[2])) throw new Exception("ticker <pair> [info]");
      $pair = $argv[2];
      $info = "last"; //default showing last price
      if(isset($argv[3])) $info = $argv[3];
      $ticker = array();
      if($pair === "btc_usd")
	$ticker = btce_btcusd_ticker();
      else if($pair === "ltc_btc")
	$ticker = btce_ltcbtc_ticker();
      else if($pair === "ltc_usd")
	$ticker = btce_ltcusd_ticker();
      else throw new Exception("unknown pair");
      echo $ticker["ticker"][$info]."\n";
    }
  else if($command === "trades")
    {
      if(!isset($argv[2])) throw new Exception("trades <pair>");
      $pair = $argv[2];
      $trades = array();
      if($pair === "btc_usd")
	$trades = btce_btcusd_trades();
      else if($pair === "ltc_btc")
	$trades = btce_ltcbtc_trades();
      else if($pair === "ltc_usd")
	$trades = btce_ltcusd_trades();
      else throw new Exception("unknown pair");
      foreach($trades as $trade)
	{
	  echo 
	    date('D M j G:i:s T Y',$trade['date']).', '.
	    $trade['price'].', '.
	    $trade['amount'].', '.
	    $trade['tid'].', '.
	    $trade['price_currency'].', '.
	    $trade['item'].', '.
	    $trade['trade_type']."\n";
	} 
    }
  else if($command === "depth")
    {
      if(!isset($argv[2])) throw new Exception("depth <pair>");
      $pair = $argv[2];
      $result = array();
      if($pair === "btc_usd")
	$result = btce_btcusd_depth();
      else if($pair === "ltc_btc")
	$result = btce_ltcbtc_depth();
      else if($pair === "ltc_usd")
	$result = btce_ltcusd_depth();
      else throw new Exception("unknown pair");
      echo "Asks: \n";
      foreach($result["asks"] as $order)
	{
	  echo 
	    $order[0].', '.
	    $order[1]."\n";
	} 
      echo "Bids: \n";
      foreach($result["bids"] as $order)
	{
	  echo 
	    $order[0].', '.
	    $order[1]."\n";
	} 
    }
  else if($command === "TransHistory")
    {
      if(!isset($argv[2]) || !isset($argv[3])) 
	throw new Exception("TransHistory <start time> <end time>");
      $start = strtotime($argv[2]);
      $end = strtotime($argv[3]);
      $result = btce_TransHistory($start,$end);
      echo "type,amount,currency,desc,status,timestamp\n";
      foreach($result as $id => $transaction)
	{
	  echo $id.', '.
	    $transaction['type'].', '.
	    $transaction['amount'].', '.
	    $transaction['currency'].', '.
	    $transaction['desc'].', '.
	    $transaction['status'].', '.
	    date('D M j G:i:s T Y',$transaction['timestamp'])."\n";
	}
    } 
  else if($command === "TradeHistory")
    {
      if(!isset($argv[2])) 
	throw new Exception("TradeHistory <count>");
      $count = $argv[2];
      $result = btce_TradeHistory($count);
      foreach($result as $id => $trade)
	{
	  echo $id.', '.
	    $trade['pair'].', '.
	    $trade['type'].', '.
	    $trade['amount'].', '.
	    $trade['rate'].', '.
	    $trade['order_id'].', '.
	    $trade['is_your_order'].', '.
	    date('D M j G:i:s T Y',$trade['timestamp'])."\n";
	}
    }
  else if($command === "ActiveOrders")
    {
      $result = btce_ActiveOrders();
      foreach($result as $id => $order)
	{
	  echo $id.', '.
	    $order['pair'].', '.
	    $order['type'].', '.
	    $order['amount'].', '.
	    $order['rate'].', '.
	    date('D M j G:i:s T Y',$order['timestamp_created']).', '.
	    $order['status']."\n";
	}
    }
  else if($command === "Trade")
    {
      for($i = 2; $i < 6; $i++) 
	if(!isset($argv[$i])) 
	  throw new Exception("Trade <pair> <type> <rate> <amount>");

      $pair = $argv[2];
      $type = $argv[3];
      $rate = $argv[4];
      $amount = $argv[5];
      $result = btce_Trade($pair,$type,$rate,$amount);
      echo "received: ".$result['received']."\n";
      echo "remains: ".$result['remains']."\n";
      echo "order_id: ".$result['order_id']."\n";
      foreach($result['funds'] as $cur => $bal)
	echo "$cur: $bal\n";
    }
  else if($command === "CancelOrder")
    {
      if(!isset($argv[2])) 
	throw new Exception("CancelOrder <order_id>");
      $order_id = $argv[2];
      $result = btce_CancelOrder($order_id);
      echo "order_id: ".$result['order_id']."\n";
      foreach($result['funds'] as $cur => $bal)
	echo "$cur: $bal\n";
    }
  else
    throw new Exception("Unknown command");
}
catch (Exception $e)
{
  echo 'Error: ', $e->getMessage(), "\n";
}

?>
