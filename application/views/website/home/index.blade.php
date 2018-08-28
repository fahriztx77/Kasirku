@extends('website.template')

@section('title') Home | {{ $__CONFIG->name }}@endsection

@section('content')
<div class="row">
  <div class="col-xs-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data Table With Full Features</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="product" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($product as $result)
            <tr>
              <td>{{ $result->product_id }}</td>
              <td>{{ $result->name }}</td>
              <td>{{ $result->price_text }}</td>
              <td align="center">
                <div class="input-group input-group-sm">
                  <input type="number" id="qty" class="form-control" data-id="{{ $result->id }}" placeholder="qty" style="width: 40px;">
                  <span class="input-group-addon">
                    {{-- <button type="button" id="addCart" onclick="addCart(this);" class="btn btn-info btn-flat" data-id="{{ $result->id }}" data-id="{{ $result->id }}"><i class="ion ion-ios-cart"></i></button> --}}enter
                  </span>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <div class="col-xs-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data Table With Full Features</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($prod as $result)
            <tr>
              <td>{{ $result->product->name }}</td>
              <td>{{ $result->product->price_text }}</td>
              <td>{{ $result->qty }}</td>
              <td align="center">
                  <span class="input-group-addon">
                    {{-- <button type="button" id="addCart" onclick="addCart(this);" class="btn btn-info btn-flat" data-id="{{ $result->id }}" data-id="{{ $result->id }}"><i class="ion ion-ios-cart"></i></button> --}}x
                  </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ base_url('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
@endsection

@section('script')
<script src="{{ base_url('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ base_url('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
var invoice = "{{ $invoice }}";
$(document).ready(function(e){
    if(invoice == ""){
        $.ajax({
            url:"{{ base_url('system/setCookieInvoice') }}",
            method:'get'
        }).done(function(response){
            var data = response.data;
            if(response.status == true){
                window.location.reload();
                return;
            }else{
                alert(data.message);
                return;
            }
        }).fail(function(response){
            var data = response.responseJSON.data;
            console.log(data);
            return;
        })
    }

    $('#product').DataTable();
    $('input[aria-controls=product]').focus();
    $('input[aria-controls=product]').keydown(function (e) {
        if (e.keyCode == 13) {
            $('#qty').focus();
            $('#qty').on('focus',function(){
                $('#qty').keydown(function (e) {
                    if(e.keyCode == 13) {
                        $(this).val('');
                        $('input[aria-controls=product]').focus();
                        addCart(this);
                        return;
                    }
                    return;
                });
            });
            return;
        }
        return;
    });

})
function addCart(that){
    var id = $(that).data('id');
    var qty = $(that).val();

    $.ajax({
        url:"{{ base_url('system/addItem') }}",
        method:'post',
        data:{id_product:id,qty:qty,invoice:invoice}
    }).done(function(response){
        var data = response.data;
        if(response.status == true){
            console.log(response);
            // window.location.reload();
            return;
        }else{
            alert(data.message);
            return;
        }
    }).fail(function(response){
        var data = response.responseJSON.data;
        console.log(data);
        return;
    })
    return;
}
</script>
@endsection