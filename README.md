trans-btce
==========

Basic command line interface to btc-e.com.
If this is useful to you, consider a BTC tip: 1E5PdkFpee1rG694VpJgjm5h8b8fqWQtvm
- Joe R - transfix@sublevels.net

Requires:
php5-cli
php5-curl

Set the environment variables BTCE_KEY and BTCE_SECRET to your auth credentials.

Usage:
$ php btce.php <command> <command args>

Commands:
- balance <currency>
  <currency> - btc/ltc/nmc etc.
  Returns your balance for the specified currency.

- server_time
  Returns the current server time.

- ticker <pair> [info]
  <pair> - btc_usd, ltc_btc, etc.
  [info] - high, low, vol, last, etc.
  If [info] is not specified, defaults to 'last'

- trades <pair>
  <pair> - btc_usd, ltc_btc, etc.
  Returns recent trades.

- depth <pair>
  <pair> - btc_usd, ltc_btc, etc.
  Returns market depth.

- TransHistory <start time> <end time>
  <start time> - string specifing time as parsable by strtotime()
  <end time>   - string specifing time as parsable by strtotime()

- TradeHistory
  <count> - number of items to show
  Returns the specifed number of items in your trade history starting from most recent.

- ActiveOrders
  Returns currently active orders.

- Trade <pair> <type> <rate> <amount>
  <pair>   - btc_usd, ltc_btc, etc.
  <type>   - 'buy' or 'sell'
  <rate>   - rate to buy/sell
  <amount> - amount to buy/sell at specified rate
  Creates a trade order.

- CancelOrder <order_id>
  <order_id> - id of order you wish to cancel
  Cancels specified order.
