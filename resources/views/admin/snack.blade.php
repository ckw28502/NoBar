<main style="margin-top:58px">
    <div class="container pt-4" id="branch">
      <section class="mb-4">
        <h1 style="color: black">Snack</h1>
        <div class="form-outline mb-4">
          <input type="text" class="form-control" id="search_branch" name="name"/>
          <label class="form-label">Nama Snack</label>
        </div>
        <button class="btn btn-primary" id="btn_search_branch">Search</button> 
        <br>
        <br>
        <button class="btn btn-primary"  data-mdb-toggle="modal" data-mdb-target="#modaladdSnack">Add new Snack!</button>
        <br>
        <br>
        <div class="accordion" id="accordionExample">
          @forelse ($data->branch as $b)
          <div class="accordion-item" id="branchacc{{$b->id}}">
            <h2 class="accordion-header" id="heading{{$b->id}}">
              <button
                class="accordion-button collapsed"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#collapse{{$b->id}}"
                aria-expanded="false"
                aria-controls="collapse{{$b->id}}"
              >
                <strong>{{$b->nama}}</strong>
              </button>
            </h2>
            <div id="collapse{{$b->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$b->id}}">
              <div class="accordion-body" style="padding-left: 2%">
                <button class="linkgantinama btn btn-secondary" data-mdb-toggle="modal"data-id='{{$b->id}}' d='{{$b->nama}}' data-mdb-target="#modaleditbranch">Ganti nama branch?</button>
                <button class="linkhapusbranch btn btn-danger" data-mdb-toggle="modal"data-id='{{$b->id}}' d='{{$b->nama}}' data-mdb-target="#modaldeletebranch">Hapus branch ini!</button>
                <a href="" class="tambahstudio btn btn-warning" data-mdb-toggle="modal"data-id='{{$b->id}}' d='{{$b->nama}}' data-mdb-target="#modaladdstudio">Add new studio here!</a>
                @forelse ($b->studio as $s)
                    <br>
                    <strong>{{$s->nama}}</strong>
                    <br>
                    <button class="linkeditstudio btn-warning btn" data-mdb-toggle="modal"data-id='{{$s->id}}' data-slot='{{$s->slot}}' d='{{$s->nama}}' data-mdb-target="#modaleditstudio">Edit studio</button>
                    <button class="linkhapusstudio btn-danger btn" data-mdb-toggle="modal"data-id='{{$s->id}}' d='{{$s->nama}}' data-mdb-target="#modalhapusstudio">Hapus studio</button>

                @empty
                    <h3>Branch ini belum punya studio</h3>
                @endforelse
            </div>
            <button onclick="Schedule(event)" value="/admin/branch/schedule/{{$b->id}}" class="btn btn-primary" style="margin-left: 2%">Cek Jadwal</button>
          </div>
          @empty
              <h1>Belum ada branch!</h1>
          @endforelse
        </div>
      </section> 
    </div>
  </main>
  <div class="modal" tabindex="-1" id="modaladdSnack">
    <div class="modal-dialog">
        <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" style='color: black;'>Add new Snack</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
              </div>
          <form action="{{url('/admin/snack/add')}}" method="get" enctype="multipart/form-data">
            @csrf
              <div class="modal-body">
                <div class='row'>
                  <div class='col-md-1'>&nbsp;</div>
                  <div class='col-md-10'>
                      <input type='text' class='form-control' placeholder='Nama Snack' id="nama_snack" name="name"><br>
                      <input type='text' class='form-control' placeholder='Harga Snack' id="harga_snack" name="harga"><br>
                      <input type='file' class='form-control' id="foto_snack" name="foto"><br>

                      <input type='radio' name='jenis_snack' checked value='Food'>&nbsp;&nbsp;&nbsp;&nbsp; Food
                      <input type='radio' name='jenis_snack' value='Beverage'>&nbsp;&nbsp;&nbsp;&nbsp; Beverage
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                {{-- <input type="submit" class="btn btn-primary" data-mdb-dismiss="modal" value="Add snack"> --}}
                <button class="btn btn-primary" data-mdb-dismiss="modal">Add Snack</button>
              </div>
          </form>
        </div>
    </div>
   </div>
  
  
  <div class="modal" tabindex="-1" id="modaleditsnack">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Studio </h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <div class="form-outline mb-4">
              <input type="text" class="form-control" id="nama_studio_edit" name="name"/>
              <label class="form-label">Nama Studio</label><br>
              <label for="slot">Jumlah Slot</label>
              <input type="number" class="form-control" id="slot_studio_edit" name="slot"/>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-mdb-dismiss="modal"id="EditStudio">Edit Studio!</button>
          </div>
      </div>
    </div>
  </div>
  
  <div class="modal" tabindex="-1" id="modalhapussnack">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Studio</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <div class="form-outline mb-4">
              <h1 id="hapusstudioh1">Yakin mau hapus Studio ini?</h1>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-mdb-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger" data-mdb-dismiss="modal"id="DeleteStudio">Yes</button>
          </div>
      </div>
    </div>
  </div>
    