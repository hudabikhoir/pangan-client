@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Form Categories</div>
                <div class="panel-body">
                    <form method="POST" action="{{ url('home/tambah')}}">
                        <div class="form-group form-group-default required">
                            {{ csrf_field() }}
                            <label>NAMA</label>
                            <input id="id" name="nama" class="form-control" required="" type="hidden" value="0">
                            <input id="name" name="nama" class="form-control" required="" type="text" value="">
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
                            <th class="col-md-9">Nama Kategori</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                foreach($content as $c){ ?>
                            <tr>
                                <td >{{ $no }}</td>
                                <td>{{$c->name}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button onclick="edit_data({{ $c->id }})" type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-xs toggler" data-prod-cat="{{ $c->id }}"><i class="fa fa-eye"></i>
                                        </button>
                                        <button onclick="hapus({{ $c->id }})" type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
                                        </button>
                                    </div> 
                                </td>
                            </tr>
                            <tr class="cat{{ $c->id }}" style="display:none">
                                <td></td>
                                <td>
                                    <input id="id-kategori-{{$c->id}}" type="hidden" value="{{ $c->id }}">
                                    <input id="id-como" type="hidden" value="0">
                                    <input id="name-como-{{$c->id}}">
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" onclick="resikComo({{$c->id}})" class="btn btn-warning btn-sm">Clear</button>
                                        <button type="button" onclick="simpanComo({{$c->id}})" class="btn btn-info btn-sm">Simpan</button>
                                    </div> 
                                </td>
                            </tr>
                            <?php $como = DB::table('comodities')->where('id_categories', $c->id)->get();
                                foreach($como as $com){
                            ?>
                            <tr class="cat{{ $c->id }}" style="display:none">
                                <td></td>
                                <td>{{ $com->name}}</td>
                                <td>
                                <div class="btn-group">
                                        <button onclick="hapus({{ $c->id }})" type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
                                        </button>
                                        <button onclick="edit_como({{ $com->id }},{{ $c->id }})" type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i>
                                        </button>
                                    </div> 
                                </td>
                            </tr>
                                <?php } $no++ ;}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Komoditas</h4>
        </div>
        <div class="modal-body">
            <table class="table-bordered table">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $(".toggler").click(function(e){
            e.preventDefault();
            $('.cat'+$(this).attr('data-prod-cat')).toggle();
        });
    });

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    function edit_data(id){
		var urlx = '{{ url("data-master/edit") }}/'+id;
		$.ajax({
			url: urlx,
			async: false,
			type: "GET",
			dataType: "json",
			success: function(data) {
                $.each(data, function(i, data) {
                    console.log(data);
                    $('#name').val(data.name).change();
                    $('#id').val(data.id).change();
                });
            }
		}); 
	}

    function simpan(){
        kirimdata = "id="+$('#id').val();
        kirimdata +="&name="+$('#name').val();
	
	    if ($('#id').val()=="0"){   
            kirimdata+="&_token= {{ csrf_token() }}";
			 $.ajax({
			  url: '{{ url("/data-master/tambah") }}',
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
			  url: '{{ url("data-master/update/") }}'+'/'+$('#id').val(),
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
					url: '{{ url("/data-master/delete") }}'+'/'+id,
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
		$('#name').val("");
		$('#id').val("0");
	}

    function resikComo(id){
		$('#name-como-'+id).val("");
		$('#id-como').val("0");
		$('#id-kategori-'+id).val("0");
	}

    function edit_como(id,ids){
		var urlx = '{{ url("data-master/comodities/edit") }}/'+id;
		$.ajax({
			url: urlx,
			async: false,
			type: "GET",
			dataType: "json",
			success: function(data) {
                $.each(data, function(i, data) {
                    console.log(data);
                    $('#name-como-'+ids).val(data.name).change();
                    $('#id-como').val(data.id).change();
                    $('#id-kategori-'+ids).val(data.id_categories).change();
                });
            }
		}); 
	}

    function simpanComo($id){
        kirimdata = "id="+$('#id-como').val();
        kirimdata +="&id_categories="+$('#id-kategori-'+$id).val();
        kirimdata +="&name="+$('#name-como-'+$id).val();
	
	    if ($('#id-como').val()=="0"){   
            kirimdata+="&_token= {{ csrf_token() }}";
			 $.ajax({
			  url: '{{ url("/data-master/comodities/tambah") }}',
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
			  url: '{{ url("data-master/comodities/update/") }}'+'/'+$('#id-como').val(),
			  async: false,
			  type: "PUT",
			  data: kirimdata,
			  dataType: "json",
			  success: function(data) {}
			}); 
            window.location.reload();
		  }
	}
</script>
@endpush