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
                            <label>NAMA</label><br>
                            <?php if(Auth::user()->id_role == '1') {?>
                            <input id="id" name="nama" class="form-control" required="" type="hidden" value="0">
                            <select id="id_user" name="id_user" class="form-control" required="" type="text" value="">
                                <option value="0">-- pilih user --</option>
                                <?php foreach($user as $us){ ?>
                                <option value="{{ $us->id }}">{{ $us->username }}</option>
                                <?php } ?>
                            </select>
                                <?php }else{ ?>
                            <label>{{ Auth::user()->username }}</label>
                            <input id="id" name="nama" class="form-control" required="" type="hidden" value="0">
                            <input id="id_user" type="hidden" value="{{ Auth::user()->id }}">
                                <?php } ?>
                        </div>
                        <div class="form-group form-group-default required">
                            <label>COMMODITIES</label>
                           <select id="id_comodities" name="id_user" class="form-control" required="" type="text" value="">
                                <option value="0">-- pilih komoditas --</option>
                                <?php foreach($comodities as $com){ ?>
                                <option value="{{ $com->id }}">{{ $com->name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group form-group-default required">
                            <label>STOCK (KG)</label>
                            <input id="stock" name="nama" class="form-control" required="" type="number" value="0">
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
                            <th class="col-md-4">User</th>
                            <th class="col-md-4">Commodities</th>
                            <th class="">Stock</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                foreach($content as $c){ ?>
                            <tr>
                                <td>{{ $no }}</td>
                                <?php if(Auth::user()->id_role == 2){?>
                                <td>{{ Auth::user()->username }}</td>
                                <?php }else{?>
                                <td>{{ $c->username }}</td>
                                <?php }?>
                                <td>{{ $c->name }}</td>
                                <td>{{ $c->stock }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button onclick="edit_data({{ $c->id }})" type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-xs toggler" data-prod-cat=""><i class="fa fa-eye"></i>
                                        </button>
                                        <button onclick="hapus({{ $c->id }})" type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})

    function edit_data(id){
		// $("#edit_jur").modal("show");
		var urlx = '{{ url("warehouse") }}/'+id;
		$.ajax({
			url: urlx,
			async: false,
			type: "GET",
			dataType: "json",
			success: function(data) {
                $.each(data, function(i, data) {
                    console.log(data);
                    // $('#is_aktif').select2("val".is_aktif).change();
                    $('#id_user').val(data.id_user).change();
                    $('#id_comodities').val(data.id_comodities).change();
                    $('#stock').val(data.stock).change();
                    $('#id').val(data.id).change();
                });
			}
		}); 
	}

    function simpan(){
        kirimdata = "id="+$('#id').val();
        kirimdata +="&id_user="+$('#id_user').val();
        kirimdata +="&id_comodities="+$('#id_comodities').val();
        kirimdata +="&stock="+$('#stock').val();
	
	    if ($('#id').val()=="0"){   
            kirimdata+="&_token= {{ csrf_token() }}";
			 $.ajax({
			  url: '{{ url("warehouse") }}',
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
			  url: '{{ url("warehouse/update/") }}'+'/'+$('#id').val(),
			  async: false,
			  type: "PUT",
			  data: kirimdata,
			  dataType: "json",
			  success: function(data) {}
			}); 
            window.location.reload();
		  }
	}

    function hapus(id){
			iziToast.question({
			timeout: 20000,
			close: false,
			overlay: true,
			toastOnce: true,
			id: 'question',
			zindex: 999,
			title: 'Hey',
			message: 'Apakah anda yakin?',
			position: 'center',
			buttons: [
				['<button><b>YA</b></button>', function (instance, toast) {
					$.ajax({
					url: '{{ url("/warehouse/delete") }}'+'/'+id,
					async: false,
					type: "DELETE",
					data: {
						"id": id,
						"_method": 'DELETE',
						"_token": '{{ csrf_token() }}',
					},
					dataType: "json",
					success: function(data) {}
				});
                    window.location.reload();
					instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');
		 
				}, true],
				['<button>TIDAK</button>', function (instance, toast) {
		 
					instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');
		 
				}]
			],
			onClosing: function(instance, toast, closedBy){
				console.info('Closing | closedBy: ' + closedBy);
			},
			onClosed: function(instance, toast, closedBy){
				console.info('Closed | closedBy: ' + closedBy);
			}
		});
	}

    function resikresik(){
		$('#id_user').val("0");
		$('#id_comodities').val("0");
		$('#stock').val("0");
		$('#id').val("0");
	}
</script>
@endpush