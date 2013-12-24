<?php

require_once('btce_query.php');

function btce_balance($currency)
{
  $result = btce_query('getInfo');
  $status = $result["success"];
  if($status != 1) throw new Exception('BTC-e query error');
  return $result["return"]["funds"][$currency];
}

function btce_server_time()
{
  $result = btce_query('getInfo');
  $status = $result["success"];
  if($status != 1) throw new Exception('BTC-e query error');
  return $result["return"]["server_time"];
}

function btce_ltc_balance()
{
  return btce_balance("ltc"); 
}

function btce_btc_balance()
{
  return btce_balance("btc"); 
}

function btce_TransHistory($since, $end)
{
  $result = btce_query('TransHistory', array('since' => "$since", 'end' => "$end"));
  $status = $result["success"];
  if($status != 1) throw new Exception('BTC-e TransHistory query error');
  return $result["return"];
}

function btce_TradeHistory($count/*$since, $end*/)
{
  //Not sure why since and end doesn't work here...
  $result = btce_query('TradeHistory', array('count' => "$count")/*, array('since' => "$since", 'end' => "$end")*/);
  $status = $result["success"];
  if($status != 1) throw new Exception('BTC-e TradeHistory query error');
  return $result["return"];
}

function btce_ActiveOrders()
{
  $result = btce_query('ActiveOrders');
  $status = $result["success"];
  if($status != 1) throw new Exception('BTC-e ActiveOrders query error');
  return $result["return"];
}

function btce_Trade($pair,$type,$rate,$amount)
{
  $result = btce_query('Trade', array('pair' => "$pair", 'type' => "$type", 'rate' => "$rate", 'amount' => "$amount"));
  $status = $result["success"];
  if($status != 1) throw new Exception('BTC-e Trade query error');
  return $result["return"];
}

function btce_CancelOrder($order_id)
{
  $result = btce_query('CancelOrder', array('order_id' => "$order_id"));
  $status = $result["success"];
  if($status != 1) throw new Exception('BTC-e CancelOrder query error');
  return $result["return"];
}

?>
