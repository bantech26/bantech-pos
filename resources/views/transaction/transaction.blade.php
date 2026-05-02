@extends('layouts.app')

@section('title', 'Dashboard Utama')

@section('content')

<div class="row row-cards">
    <div class="col-lg-9">
        <div class="row row-cards">
            <div class="col-md-4">
                <div class="card" style="height: 200px;">
                    <div class="card-body">

                        <div class="mb-3 row">
                          <label class="col-3 col-form-label">Date</label>
                          <div class="col">

                            <div class="input-icon mb-2">
                                <input class="form-control" placeholder="Select a date" id="datepicker-icon" value="2020-06-20" disabled>
                                <span class="input-icon-addon"><!-- Download SVG icon from http://tabler.io/icons/icon/calendar -->
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                    <path d="M16 3v4"></path>
                                    <path d="M8 3v4"></path>
                                    <path d="M4 11h16"></path>
                                    <path d="M11 15h1"></path>
                                    <path d="M12 15v3"></path></svg></span>
                              </div>

                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-3 col-form-label">Cashier</label>
                          <div class="col">
                            <input type="text" class="form-control" value="{{ Auth::user()->employe->full_name }}" disabled>
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-3 col-form-label">Product</label>
                          <div class="col">
                            
                              <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Scan barcode..." id="barcode-input">
                                    <button class="btn btn-primary btn-icon" type="button" data-bs-toggle="modal" data-bs-target="#modal-product">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg>
                                    </button>
                                </div>

                          </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="height: 200px;">
                    <div class="card-body">

                        <div class="mb-3 row">
                          <label class="col-3 col-form-label">Member</label>
                          <div class="col">

                              <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Scan Member..." id="member-input">
                                    <button class="btn btn-primary btn-icon" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg>
                                    </button>
                                </div>
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-3 col-form-label">Name</label>
                          <div class="col">
                            <input type="text" class="form-control" id="mamber-name" value="Umum" disabled>
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-3 col-form-label">Point</label>
                          <div class="col">
                            <input type="text" class="form-control"  id="mamber-point" value="0" disabled>
                          </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="height: 200px;">
                    <div class="card-body">
                        
                        <div>
                            <h2 class="mb-3">TOTAL</h2>
                            <div class="display-4 fw-bold text-primary" id="grandTotal">Rp 0</div>
                        </div>

                        <div class="mt-2">
                            <h2 class="text-warning fw-bold">
                                Discount Item : <span id="displayDiscount">Rp 0</span>
                            </h2>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="table-responsive" style="min-height: 450px; max-height: 450px; overflow-y: auto;">
                        <table class="table table-vcenter card-table table-bordered table-striped">
                            <thead class="text-center"> <tr>
                                <tr>
                                    <th style="background-color: #066fd1 !important; color: #fff !important; width: 5%;">Aksi</th>
                                    <th style="background-color: #066fd1 !important; color: #fff !important; width: 20%;">Product Item</th>
                                    <th style="background-color: #066fd1 !important; color: #fff !important; width: 15%;">Uom</th>
                                    <th style="background-color: #066fd1 !important; color: #fff !important; width: 15%;">Price</th>
                                    <th style="background-color: #066fd1 !important; color: #fff !important; width: 10%;">Qty</th>
                                    <th style="background-color: #066fd1 !important; color: #fff !important; width: 15%;">Discount</th>
                                    <th style="background-color: #066fd1 !important; color: #fff !important; width: 20%;">Total</th>
                                </tr>
                            </thead>
                            <tbody id="transaction-table-body">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card" style="height: 100%; min-height: 620px;">
            <div class="card-body d-flex flex-column justify-content-between ">

                    <div class="mb-3">
                      <label class="form-label">InvoiceNo</label>
                      <input type="text" class="form-control" name="example-text-input" value="{{ $transaction_id }}" disabled>
                    </div>
                
                    <div class="mb-3">
                      <label class="form-label">Sub Total</label>
                      <input type="text" class="form-control" name="example-text-input" disabled>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Discount Point</label>
                      <input type="text" class="form-control" name="example-text-input discount-sub-total" value="0">
                        <label class="form-check mt-2">
                          <input class="form-check-input" type="checkbox">
                          <span class="form-check-label">Using all point</span>
                        </label>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Discount (Rp.)</label>
                      <input type="text" class="form-control" name="example-text-input discount-sub-total" value="0">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Grand Total</label>
                      <input type="text" class="form-control" name="example-text-input" disabled>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Payment Type</label>
                            <select class="form-select">
                                <option value="1">Cash</option>
                                <option value="2">Qris</option>
                                <option value="3">Transfer</option>
                            </select>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Cash</label>
                        <div class="btn-list mb-3">
                        <a class="btn btn-square btn-primary"> 20.000 </a>
                        <a class="btn btn-square btn-secondary"> 50.000 </a>
                        <a class="btn btn-square btn-success"> 100.000 </a>
                        <a class="btn btn-square btn-warning"> 200.000 </a>
                        </div>
                      <input type="text" class="form-control" name="example-text-input" >
                    </div>
                    <div class="mt-auto">
                        <button class="btn btn-success w-100 btn-lg">Payement (F12)</button>
                    </div>
            </div>
        </div>
    </div>
</div>


{{-- //MODAL Member --}}




{{-- //MODAL PRODUCT --}}
<div class="modal modal-blur fade" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Search Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="mb-3">
                <input type="text" id="search-input-modal" class="form-control" placeholder="Ketik nama atau barcode barang...">
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter table-striped">
                    <thead>
                        <tr>
                            <th>Prodct Code</th>
                            <th>UoM</th>
                            <th>Price</th>
                            <th class="w-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="result-table-body">
                        <!-- Hasil pencarian akan muncul di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
    <!-- Pastikan Axios & jQuery sudah terload di master layout -->
    <script src="{{ asset('js/transaction.js') }}"></script>
@endpush
