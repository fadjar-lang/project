@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div> --}}
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="tambah" data-bs-target="#exampleModal">
        Tambah Data
      </button>
      <br>
      <br>
    <table class="table table-striped" id="tabel1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nip</th>
                <th>Tgl lahir</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
  
</div>
<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Data Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" placeholder="nama">
                <input type="hidden" name="id" id="id">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nip</label>
                <input type="text" class="form-control" name="nip" id="nip" placeholder="nip">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Tgl lahir</label>
                <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="nama">
              </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="tutup" data-bs-dismiss="modal">Close</button>
          <button type="button" id="simpan" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function(){
        isi();
    });

    function isi() {
        $('#tabel1').DataTable({
            serverside : true,
            responsive : true,
            ajax : {
                url : "{{route('data')}}"
            },
            columns: [
                {data: 'nama', name: 'nama'},
                {data: 'nip', name: 'nip'},
                {data: 'tgl_lahir', name: 'tgl_lahir'},
                {data: 'aksi', name: 'aksi'},
            ]
        })
    }
</script>
<script>
    $('#simpan').on('click', function(){
        if ($(this).text() === 'simpan edit') {
            // console.log("edit");
            edit();
        }else{
            tambah();
        }

      
    })

    $(document).on('click', '.edit', function(){
        let id = $(this).attr('id');
        $('#tambah').click();
        $('#simpan').text('simpan edit');

        $.ajax({
            url : "{{route('edit')}}",
            type : 'post',
            data : {
                id : id,
                _token : "{{csrf_token()}}"
            },
            success : function (res) {
                $('#id').val(res.data.id);
                $('#nama').val(res.data.nama);
                $('#nip').val(res.data.nip);
                $('#tgl_lahir').val(res.data.tgl_lahir);
            }
        })
    })

    function tambah(){
        $.ajax({
            url: "{{route('store')}}",
            type: 'post',
            data: {
                nama : $('#nama').val(),
                nip : $('#nip').val(),
                tgl_lahir : $('#tgl_lahir').val(),
                "_token" : "{{csrf_token()}}"
            },
            success : function (res) {
                console.log(res);
                alert(res.text)
                $('#tutup').click()
                $('#tabel1').DataTable().ajax.reload()
                $('#nama').val(null);
                $('#nip').val(null);
                $('#tgl_lahir').val(null);
            },
            error : function(xhr) {
                alert(xhr.responJson.text);
            }
        })  
    }

    function edit() {
        $.ajax({
            url: "{{route('update')}}",
            type: 'post',
            data: {
                id : $('#id').val(),
                nama : $('#nama').val(),
                nip : $('#nip').val(),
                tgl_lahir : $('#tgl_lahir').val(),
                "_token" : "{{csrf_token()}}"
            },
            success : function (res) {
                console.log(res);
                alert(res.text)
                $('#tutup').click()
                $('#tabel1').DataTable().ajax.reload()
                $('#nama').val(null);
                $('#nip').val(null);
                $('#tgl_lahir').val(null);
                $('#simpan').text('simpan');
            },
            error : function(xhr) {
                alert(xhr.responJson.text);
            }
        })
    }
    
    $(document).on('click','.hapus', function () {
        let id = $(this).attr('id')
        $.ajax({
            url : "{{route('hapus')}}",
            type : 'post',
            data: {
                id: id,
                "_token" : "{{csrf_token()}}"
            },
            success: function (params) {
                alert(params.text)
                $('#tabel1').DataTable().ajax.reload()
            }
        })
    })
</script>
@endpush
@endsection
