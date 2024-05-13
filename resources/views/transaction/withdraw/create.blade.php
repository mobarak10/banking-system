@section('title', 'New Withdraw')

<x-app-layout>
    <div class="container">
        <!-- Start header widget -->
        <div class="widget mb-3">
            <div class="widget-body d-flex">
                <!-- Start left menu -->
                <nav class="navbar navbar-expand-lg d-none print-none d-md-block">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('transaction.withdraw') }}">
                                <i class="bi bi-plus-square"></i>
                                <span>All Withdraw</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End left menu -->

                <div class="ms-auto">
                    <button type="button" class="btn icon lg rounded" title="Go back" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- End header widget -->

        <!-- Start body widget =================================== -->
        <div class="widget mb-5">
            <div class="widget-head mb-3">
                <h5>New Withdraw</h5>
                <p><small>Must fill star (<span class="text-danger fw-bold">*</span>) pointed boxes</small></p>
            </div>

            <div class="widget-body" id="root">
                <form action="{{ route('transaction.storeWithdraw') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name_en" class="form-label required">Amount</label>
                            <input type="number" step="any" class="form-control @error('amount') is-invalid @enderror" id="amount"
                                   name="amount" value="{{ old('amount') }}" placeholder="Enter amount">
                            @if($account_type === 'individual')
                                <small>Friday withdraw id free, First 1K is free, Every Month 5K is free, After that every withdraw cost 0.015% fee</small>
                            @else
                                <small>First 50k fee is 0.025% then 0.015%</small>
                            @endif
                            @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-2 text-end">
                        <button class="btn btn-danger mx-2" type="reset">
                            <i class="bi bi-stars"></i> Reset </button>
                        <button class="btn btn-success" type="submit">
                            <i class="bi bi-download"></i> Save
                        </button>
                    </div>
                </form>
            </div>

        </div>
        <!-- End body widget =================================== -->
    </div>
</x-app-layout>
