@extends('layouts.user')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Payment Confirmation</h3>
                        </div>
                        <div class="card-body">
                            <h4 class="text-center">Total Payment</h4>
                            <h2 class="text-center">{{ $order['total_payment'] }}</h2>
                            <p>Rekening PT. Pasar Dunia Seafood</p>
                            <p>Bank Name: BCA</p>
                            <p>Bank Account Name : PT. PASAR DUNIA SEAFOOD</p>
                            <p>Bank Account Number :123456789 </p>
                            <br>
                            <p>Due Time Payment : {{$order['created_at']->addMonth(1)->format('d-F-Y')}}</p>
                            <hr>
                            <form action="{{ route('my.order.detail.upload.save', $order['id']) }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PATCH">
                                @csrf
                                <div class="row">
                                <div id="dp" class="col-6">
                                    <label>Jumlah DP</label>
                                    <input type="number" class="form-control" name="dp" required>

                                    @if($order['payment_proof'] !== null)
                                        <img src="{{ $order['payment_proof'] }}" style="height: 300px; width: auto">
                                        <br>
                                        @endif
                                    <label>Proof Of Payment (DP)</label>
                                    <input type="file" id="payment_proof" name="payment_proof" class="form-control" id="fileToUpload">

                                </div>
                                <div id="cash" class="col-6">
                                    @if($order['payment_proof_final'] !== null)
                                        <img src="{{ $order['payment_proof_final'] }}" style="height: 300px; width: auto">
                                        <br>
                                        @endif
                                    <label>Proof Of Payment (DONE)</label>
                                    <input type="file" id="payment_proof_final" name="payment_proof_final" class="form-control" id="fileToUpload">
                                </div>
                                </div>
                                <br>
                                <button id="btn-submit" type="submit" class="btn btn-primary">Upload</button>
                            </form>

                        </div>

                        <!-- /.card-body -->
                    </div>
                </div><!-- /.container-fluid -->
    </section>
@endsection
