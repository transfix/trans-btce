trans-btce
==========

Basic command line interface to btc-e.com.<br/>
If this is useful to you, consider a BTC tip: 1E5PdkFpee1rG694VpJgjm5h8b8fqWQtvm<br/>
Joe R - transfix@sublevels.net

Requirements
------------
* php5-cli
* php5-curl

Set the environment variables BTCE\_KEY and BTCE\_SECRET to your auth credentials.

Usage
-----
    $ php btce.php <command> <command args>

Commands
--------
- balance &lt;currency&gt;<br/>
  &lt;currency&gt; - btc/ltc/nmc etc.
  Returns your balance for the specified currency.

- server\_time<br/>Returns the current server time.

- ticker &lt;pair&gt; &#91;info&#93;<br/>
  &lt;pair&gt; - btc\_usd, ltc\_btc, etc.<br/>
  &#91;info&#93; - high, low, vol, last, etc.<br/>
  If &#91;info&#93; is not specified, defaults to 'last'

- trades &lt;pair&gt;<br/>
  &lt;pair&gt; - btc_usd, ltc\_btc, etc.<br/>
  Returns recent trades.

- depth &lt;pair&gt;<br/>
  &lt;pair&gt; - btc_usd, ltc\_btc, etc.<br/>
  Returns market depth.

- TransHistory &lt;start time&gt; &lt;end time&gt;<br/>
  &lt;start time&gt; - string specifing time as parsable by strtotime()<br/>
  &lt;end time&gt;   - string specifing time as parsable by strtotime()<br/>

- TradeHistory &lt;count&gt;<br/>
  &lt;count&gt; - number of items to show</br>
  Returns the specifed number of items in your trade history starting from most recent.

- ActiveOrders<br/>
  Returns currently active orders.

- Trade &lt;pair&gt; &lt;type&gt; &lt;rate&gt; &lt;amount&gt;<br/>
  &lt;pair&gt;   - btc\_usd, ltc\_btc, etc.<br/>
  &lt;type&gt;   - 'buy' or 'sell'<br/>
  &lt;rate&gt;   - rate to buy/sell<br/>
  &lt;amount&gt; - amount to buy/sell at specified rate<br/>
  Creates a trade order.

- CancelOrder &lt;order\_id&gt;<br/>
  &lt;order\_id&gt; - id of order you wish to cancel<br/>
  Cancels specified order.
