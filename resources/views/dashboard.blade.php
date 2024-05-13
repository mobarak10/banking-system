<x-app-layout>
    <div class="row mt-3 mx-5">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Current Balance</h5>
                    <p class="card-text">{{ number_format($user?->balance, 2) }}</p>
                    <a href="#" class="btn btn-primary">Show All Transaction</a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Deposit</h5>
                    <p class="card-text">{{ number_format($user?->total_deposit, 2) }}</p>
                    <a href="#" class="btn btn-primary">Show All Deposit</a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Withdraw</h5>
                    <p class="card-text">{{ number_format($user?->total_withdraw, 2) }}</p>
                    <a href="#" class="btn btn-primary">Show All Withdraw</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
