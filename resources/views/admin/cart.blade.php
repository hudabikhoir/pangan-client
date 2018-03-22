@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
					<div class="form-group form-group-default required">
						<label>COMMODITIES</label>
						<select onchange="isi_otomatis(this)" id="id_comodities" name="id_user" class="form-control" required="" type="text" value="">
							<option value="0">-- pilih komoditas --</option>
							<?php foreach($comodities as $com){ ?>
							<option value="{{ $com->id }}">{{ $com->comodities }}</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group form-group-default required">
						<label>Jumlah (KG)</label>
						<input id="amount" class="form-control" required="" type="number" value="0">
					</div>
					<label id="price"></label>
					<button class="btn btn-block btn-primary" type="button" onclick="simpan()">
                            <span class="bold">Simpan</span>
                        </button>        
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Keranjang</div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <th widht="2px">#</th>
                            <th class="col-md-4">Commodities</th>
                            <th class="">Jumlah</th>
                            <th class="">Harga (kg)</th>
                            <th class="">Action</th>
                        </thead>
                        <tbody>
                           <?php $no = 1; foreach($content as $con){ ?>
						   <tr>
								<td>{{ $no }}</td>
								<td>{{ $con->comodities }}</td>
								<td>{{ $con->amount }}</td>
								<td>{{ $con->price }}</td>
								<td>
									<div class="btn-group">
										<button onclick="hapus({{ $con->id }})" type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
										</button>
									</div>
								</td>
						   </tr>
						   <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function isi_otomatis(sel){
		var stock = $("#stock").val();
        $.ajax({
			url: '{{ url("/cart/harga") }}/'+sel.value,
			dataType: "json",
			success: function(data) {
				$.each(data, function(i, data) {
					console.log(new Intl.NumberFormat().format(data.price));
					$('#price').text("Rp. " + new Intl.NumberFormat().format(data.price));
				});
			}
		});
	}  
    function simpan(){
        kirimdata = "id="+$('#id').val();
        kirimdata +="&id_comodities="+$('#id_comodities').val();
        kirimdata +="&amount="+$('#amount').val();
	    kirimdata+="&_token= {{ csrf_token() }}";
		$.ajax({
			url: '{{ url("cart") }}',
			async: false,
			type: "POST",
			data: kirimdata,
			dataType: "json",
			success: function(data) {}
		}); 
        window.location.reload();
	}
</script>
@endpush