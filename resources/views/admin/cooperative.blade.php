@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Form Warehouse</div>
                <div class="panel-body">
                    <form method="POST" action="{{ url('')}}">
                        <div class="form-group form-group-default required">
                            {{ csrf_field() }}
                            <label>PRICE (Rp.)</label>
                            <input id="id" class="form-control" required="" type="hidden" value="0">
                            <input id="id_comodities" class="form-control" required="" type="hidden" value="0">
                            <input id="price" class="form-control" required="" type="number" value="0">
                        </div>
                        <button class="btn btn-block btn-primary" type="button" onclick="simpan()">
                            <span class="bold">Simpan</span>
                        </button>
                        <button class="btn btn-block btn-danger" type="button" onclick="resikresik()">
                            <span class="bold">Bersihkan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Data Master</div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <th widht="2px">#</th>
                            <th class="col-md-4">Commodities</th>
                            <th class="">Stock</th>
                            <th class="col-md-4">Price</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                foreach($content as $c){ ?>
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $c->name }}</td>
                                <td>{{ $c->stock }}</td>
                                <td>{{ $c->price }} <input id="input-price" type="hidden"></td>
                                <td>
                                    <div class="btn-group">
                                        <button onclick="edit_data({{ $c->id_comodities}})" type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                                        </button>
                                    </div> 
                                </td>
                            </tr>
                            <?php $no++ ; } ?>
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
    function edit_data(id){
		// $("#edit_jur").modal("show");
		var urlx = '{{ url("cooperative") }}/'+id+"/edit";
		$.ajax({
			url: urlx,
			async: false,
			type: "GET",
			dataType: "json",
			success: function(data) {
                $.each(data, function(i, data) {
                    console.log(data);
                    // $('#is_aktif').select2("val".is_aktif).change();
                    $('#id_comodities').val(data.id_comodities).change();
                    $('#price').val(data.price).change();
                    $('#id').val(data.id).change();
                });
			}
		}); 
	}

    function simpan(){
        kirimdata = "id="+$('#id').val();
        kirimdata +="&id_comodities="+$('#id_comodities').val();
        kirimdata +="&price="+$('#price').val();
	
	    if ($('#id').val()==""){   
            kirimdata+="&_token= {{ csrf_token() }}";
			 $.ajax({
			  url: '{{ url("cooperative") }}',
			  async: false,
			  type: "POST",
			  data: kirimdata,
			  dataType: "json",
			  success: function(data) {}
			}); 
            window.location.reload();
		  }else{  
             kirimdata+="&_method= PUT";
             kirimdata+="&_token= {{ csrf_token() }}";
			 $.ajax({
			  url: '{{ url("cooperative") }}'+'/'+$('#id').val(),
			  async: false,
			  type: "PUT",
			  data: kirimdata,
			  dataType: "json",
			  success: function(data) {}
			}); 
            window.location.reload();
		  }
	}

    function resikresik(){
		$('#id_comodities').val("");
		$('#price').val("0");
		$('#id').val("");
	}
</script>
@endpush