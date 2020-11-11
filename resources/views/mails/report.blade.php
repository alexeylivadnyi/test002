<h1>New Report</h1>

<hr>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Client</th>
            <th>Product</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->client->name }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->total }}$</td>
                <td>{{ $item->date->format(config('app.date_format')) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
