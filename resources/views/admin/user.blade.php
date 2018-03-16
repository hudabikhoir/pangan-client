@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Data Master</div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <th widht="2px">#</th>
                            <th class="col-md-4">User</th>
                            <th class="col-md-4">Email</th>
                            <th class="">Role</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr>
                            <?php 
                                $no = 1;
                                foreach($content as $c){ ?>
                                <td>{{ $no }}</td>
                                <td>{{ $c->username }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->id_role }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-xs toggler" data-prod-cat=""><i class="fa fa-eye"></i></button>
                                        <button onclick="hapus({{ $c->id }})" type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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
					url: '{{ url("/user/delete") }}'+'/'+id,
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
		$('#email').val("");
		$('#id_role').val("0");
		$('#id').val("0");
	}
</script>
@endpush