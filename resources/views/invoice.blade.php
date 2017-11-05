<article class="{{ $order->status }} {{ $order->source }}">
  <header>
    <section class="company">
      <h1>Invoice</h1>
      <h2>{{ config("settings.accounts.$order->account.company.name") }}</h2>
      @foreach(config("settings.accounts.$order->account.company.info") as $company_line)
      <p>{{ $company_line }}</p>
      @endforeach
    </section>
    <section class="shipping">
      <h2>Bill to:</h2>
      <p>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
      <p>{{ $order->customer->address->line_1 }}</p>
      <p>{{ $order->customer->address->line_2 }}</p>
      <p>{{ $order->customer->address->line_3 }}</p>
      <p>{{ $order->customer->address->city }}, {{ $order->customer->address->region }}</p>
      <p>{{ $order->customer->address->postal_code }}, {{ $order->customer->address->country_code }}</p>
    </section>
    <section class="customer">
      <div class="column">
        <p title="Reference">{{ $order->reference }}&nbsp;</p>
        <p title="Order ID">{{ $order->order_id }}&nbsp;</p>
        <p title="Source">{{ $order->source }}&nbsp;</p>
        <p title="Service">{{ $order->service }}&nbsp;</p>
      </div>
      <div class="column">
        <p title="Customer Ref.">{{ $order->customer->id }}&nbsp;</p>
        <p title="Email">{{ $order->customer->email }}&nbsp;</p>
        <p title="Telephone">{{ $order->customer->telephone }}&nbsp;</p>
        <p title="Courier"><strong>{{ $order->courier_code }}</strong> {{ $order->courier->name }}&nbsp;</p>
      </div>
    </section>
  </header>
  <main>
    @if (count($order->products))
    <table class="items">
      <thead>
        <tr>
          <th class="sku">SKU</th>
          <th class="img">Image</th>
          <th class="item">Item</th>
          <th class="tax">Pricing</th>
          <th class="price">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->products as $product)
        <tr>
          <td class="sku">{{ $product->sku }} @if($product->sku) <br /><br /> @endif ({{ $product->id }})</td>
          <td class="img"><img src="{{ $product->image_url }}" /></td>
          <td class="item">{{ $product->name }}</td>
          <td class="tax">{{ config('settings.currency_symbol') }}{{ number_format($product->price - ($product->price * config('settings.tax')), 2) }}<br /><sub>+ {{ config('settings.currency_symbol') }}{{ number_format($product->price * config('settings.tax'), 2) }} VAT</sub></td>
          <td class="price">{{ config('settings.currency_symbol') }}{{ number_format($product->price, 2) }}<br/><sub>{{ config('settings.currency_symbol') }}{{ number_format($product->shipping, 2) }} P&amp;P incl</sub></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <section class="info">
      <p class="total"><strong>Total:</strong> {{ config('settings.currency_symbol') }}{{ number_format($order->total_price, 2) }}</p>
      <p class="message">{{ $order->order_message }}</p>
    </section>
    @else
    <h1 class="no-items">Thank you for ordering with {{ config("settings.accounts.$order->account.company.name") }}</h1>
    @endif
  </main>
  <footer>
    <section class="additional"></section>
    <address class="courier">
      <h2>Ship To:</h2>
      <p>{{ $order->address->first_name }} {{ $order->address->last_name }}</p>
      <p>{{ $order->address->line_1 }}</p>
      <p>{{ $order->address->line_2 }}</p>
      <p>{{ $order->address->line_3 }}</p>
      <p>{{ $order->address->city }}, {{ $order->address->region }}</p>
      <p>{{ $order->address->postal_code }}</p>
      <p>{{ $order->address->country_code }}</p>
    </address>
  </footer>
</article>
