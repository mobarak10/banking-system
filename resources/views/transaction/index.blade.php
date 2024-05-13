@section('title', 'All Transaction')

<x-app-layout>
    <div class="container">
        <!-- Start header widget -->
        <div class="widget mb-3  print-none">
            <div class="widget-body d-flex">
                <!-- Start right button -->
                <div class="ms-auto">
                    <button type="button" class="btn icon lg rounded" title="Print"
                            onclick="window.print()">
                        <i class="bi bi-printer"></i>
                    </button>
                    <a class="btn icon lg rounded" title="Reload" href="#">
                        <i class="bi bi-bootstrap-reboot"></i>
                    </a>
                    <button type="button" class="btn icon lg rounded" title="Go back" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
                <!-- End right button -->
            </div>

        </div>
        <!-- End header widget -->


        <!-- Start body widget -->
        <div id="print-widget">

            <div class="widget">
                <div class="widget-head mb-3">
                    <h5>All Transaction</h5>
                    <p><small>Total Result found 10 </small></p>
                </div>
                <div class="widget-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 70px;">
                                    SL
                                </th>
                                <th>Date</th>
                                <th class="text-center">Type</th>
                                <th class="text-end">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $index => $transaction)
                                    <tr>
                                        <th>{{ $transactions?->firstItem() + $index }}</th>
                                        <td>{{ \Carbon\Carbon::parse($transaction?->date)->format('d F Y') }}</td>
                                        <td class="text-center">{{ $transaction?->transaction_type }}</td>
                                        <td class="text-end">{{ number_format($transaction?->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Body widget -->
        <nav aria-label="..." class=" float-end mt-4">
            {{ $transactions->links() }}
        </nav>
    </div>
</x-app-layout>
