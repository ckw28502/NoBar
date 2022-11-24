@extends('master.masterlayout')
@section('body')
    <x-sidebaradmin></x-sidebaradmin>
    <div id="div_dashboard" style="display:block">
      @include('admin.dashboard')
    </div>
    <div id="div_branch" style="display:none">
      @include('admin.branch')
    </div>
    <div id="div_movie"style="display: none">
      @include('admin.movie')
    </div>
    <div id="div_schedule"style="display: none">
      @include('admin.schedule')
    </div>
    <div id="div_snack"style="display: none">
      @include('admin.snack')
    </div>
    <div id="div_add"style="display: none">
      @include('admin.movieadd')
    </div>
@endsection
@section('pageScript')
<script>
  // console.log("HEY")
  $(document).ready(function () {
    //Reload();
  });
  var current=0;
  var cbranch=-1
  var cstudio=-1
  var cmov=-1
  var produser=[];
  var casts=[]
  var director=[]
  const page=["dashboard","branch","movie","snack"];
  var genre=["comedy","horror","action","romance","fantasy"]
    function Reload(data){
      $("#accordionExample").html("")
      var str="";
      data.forEach(d => {
        str+="<div class='accordion-item' id='branchacc"+d.id+"'><h2 class='accordion-header' id='heading"+d.id+"'><button class='accordion-button collapsed'type='button'data-mdb-toggle='collapse'data-mdb-target='#collapse"+d.id+"'aria-expanded='false'aria-controls='collapse"+d.id+"'><strong>"+d.nama+"</strong></h2><div id='collapse"+d.id+"' class='accordion-collapse collapse' aria-labelledby='heading"+d.id+"'><div class='accordion-body' style='padding-left: 2%'><button class='linkgantinama btn btn-secondary' data-mdb-toggle='modal' data-id='"+d.id+"' d='"+d.nama+"' data-mdb-target='#modaleditbranch'>Ganti nama branch?</button><button class='linkhapusbranch btn btn-danger' data-mdb-toggle='modal'data-id='"+d.id+"' d='"+d.nama+"' data-mdb-target='#modaldeletebranch'>Hapus branch ini!</button><button class=' tambahstudio btn btn-warning' data-mdb-toggle='modal'data-id='"+d.id+"' d='"+d.nama+"' data-mdb-target='#modaladdstudio'>Add new studio here!</button>"
        if (d.studio.length>0) {
          d.studio.forEach(s=>{
            str+="<br><strong>"+s.nama+"</strong><br><button class='linkeditstudio btn-warning btn' data-mdb-toggle='modal'data-id='"+s.id+"'data-slot='"+s.slot+"' d='"+s.nama+"' data-mdb-target='#modaleditstudio'>Edit studio</button><button class='linkhapusstudio btn-danger btn' data-mdb-toggle='modal'data-id='"+s.id+"' d='"+s.nama+"' data-mdb-target='#modalhapusstudio'>Hapus studio</button>"
          })
        } else {
          str+="<h3>Branch ini belum punya studio</h3>"
        }
        str+="</div><button onclick='ScheduleBranch(event)' value='"+d.id+"'class='btn btn-primary' style='margin-left: 2%'>Cek Jadwal</button></div></div>"
          });
          $("#accordionExample").html(str)
    }
    function delproducer(e) {
      const i=$(e.target).val()
      produser.splice(i,1)
      ReloadProducer()
    }
    function deldirektur(e) {
      const i=$(e.target).val()
      director.splice(i,1)
      ReloadDirector()
    }
    function delcast(e) {
      const i=$(e.target).val()
      casts.splice(i,1)
      ReloadCast()
    }
    function ReloadProducer() {
      var c=""
      var i=0
      produser.forEach(p => {
        c+="<b>"+p+"</b><button class='btn btn-danger justify-content-end align-items-center' style='position:relative; left:60%;' onclick='delproducer(event)' value='"+i+"'>Delete</button><br>"
        i++
      });
      $("#list_produser").html(c)
    }
    function ReloadDirector() {
      var c=""
      var i=0
      director.forEach(d => {
        c+="<b>"+d+"</b><button class='btn btn-danger justify-content-end align-items-center' style='position:relative; left:60%;' onclick='deldirektur(event)' value='"+i+"'>Delete</button><br>"
        i++
      });
      $("#list_direktur").html(c)
    }
    function ReloadCast() {
      var c=""
      var i=0
      casts.forEach(ca => {
        c+="<b>"+ca+"</b><button class='btn btn-danger justify-content-end align-items-center' style='position:relative; left:60%;' onclick='delcast(event)' value='"+i+"'>Delete</button><br>"
        i++
      });
      $("#list_cast").html(c)
    }
    function ReloadMovie(data) { 
      var c=$("#containermovie")
      c.html("")
      var str=""
      if (data.length>0) {
        data.forEach(d=>{
          str+="<div class='card' style='width: 30%; display: inline-block; margin: 9%;''><div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light' ><img src='storage/movie/"+d.image+"' class='img-fluid' alt='"+d.slug+"'/><a href=''><div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div></a></div><div class='card-body'><h5 class='card-title text-dark'>"+d.judul+"</h5><p class='card-text'>Genre :<br>"+d.genre+"<br>Duration :<br>"+d.duration+"<br></p><button onclick='ScheduleMovie(event)' value='"+d.id+"' class='btn btn-primary'>Jadwal</button><button href='' value='"+d.id+"' class='movieedit btn btn-warning'>Edit</button><button href='' data-mdb-toggle='modal' value='"+d.id+"' d='"+d.judul+"' data-mdb-target='#modaldeletemovie' class='delmovie btn btn-danger'>Delete</button></div></div>"
        })
      } else {
        str="<h2>Belum ada film yang main!</h2>"
      }
      c.html(str)
     }
     $("#movsec").on("click",".movieedit",function () {
      var id=$(this).val()
      $.ajax({
        type:"get",
        url:'{{url('/admin/movie/get')}}',
        data:{
          id:id
        },success: function (data) {
          const m=JSON.parse(data,false)
          $("#movie_judul").val(m.judul)
          produser=m.producer.split(", ")
          director=m.director.split(", ")
          casts=m.casts.split(", ")
          $("#synopsis").val(m.synopsis)
          const temp=m.genre.split(", ")
          $("#durasi").val(m.duration)
          temp.forEach(g => {
            $("#add_"+g).prop("checked",true)
          });
          ReloadProducer()
          ReloadDirector()
          ReloadCast()
          $("#div_add").css("display","block")
          $("#div_movie").css("display","none")
          $("#addmovie").val("edit")
        $("#addmovie").text("Edit Film")
        $("#juduladd").text("Edit Film "+m.judul)
        cmov=id
        }
      })
     })
    function ScheduleBranch(e) {
    const id=$(e.target).val();
    $.ajax({
      type: "get",
      url: "{{url('/admin/branch/schedule')}}",
      data:{
        id:id
      },
      success: function (response) {
        $("#div_schedule").css("display","block");
        for (let i = 0; i < page.length; i++) {
          const p = page[i];
          $("#div_"+p).css("display","none");
        };
        const data=JSON.parse(response);
        Schedule(data)
      }
    })};
    function ScheduleMovie(e) {
    const id=$(e.target).val();
    $.ajax({
      type: "get",
      url: "{{url('/admin/movie/schedule')}}",
      data:{
        id:id
      },
      success: function (response) {
        $("#div_schedule").css("display","block");
        for (let i = 0; i < page.length; i++) {
          const p = page[i];
          $("#div_"+p).css("display","none");
        };
        const data=JSON.parse(response);
        Schedule(data)
      }
    })};
    function Schedule(data){
      const tbody=$("#schedule_table");
        tbody.html("");
        for (let i = 0; i < data.schedule.length; i++) {
          const tr=document.createElement("tr");
          const td1=document.createElement("td");
          td1.innerHTML=data.schedule[i].nama_branch
          const td2=document.createElement("td");
          td2.innerHTML=data.schedule[i].nomor_studio
          const td3=document.createElement("td");
          td3.innerHTML=data.schedule[i].judul_movie
          const td4=document.createElement("td");
          td4.innerHTML=data.schedule[i].time
          const td5=document.createElement("td");
          td5.innerHTML=data.schedule[i].durasi + " menit"
          const td6=document.createElement("td");
          td6.innerHTML=data.schedule[i].price
          tr.append(td1,td2,td3,td4,td5,td6);
          tbody.append(tr);
        }
      };

    function PageChange(e){
      current=$(e.target).attr("target");
      $("#div_schedule").css("display","none");
      for (let i = 0; i < page.length; i++) {
        const p = page[i];
        if (i==current) {
          $("#nav_"+p).addClass("active");
          $("#div_"+p).css("display","block");
        } else {
          $("#nav_"+p).removeClass("active");
          $("#div_"+p).css("display","none");
        }
      };
      $("#div_add").css("display","none");
      $("#div_edit").css("display","none");
    } 
    
    $("#EditBranch").on("click",function(){
      const nama=$("#nama_branch_edit").val();
      if (nama.length>0) {
        dn=$.ajax({
        type:"post",
        url:'{{url("/admin/branch/edit")}}',
        data: {
          _token:'{{ csrf_token() }}',
          nama:nama,
          id:cbranch
        },
        success:function(data){
          var d=JSON.parse(data,false)
          Reload(d)
        }
      })
      } else {
        alert("Nama tidak boleh kosong!");
      }
    })
    $("#DeleteBranch").on("click",function(){
      dn=$.ajax({
        type:"post",
        url:'{{url("/admin/branch/delete")}}',
        data: {
          _token:'{{ csrf_token() }}',
          id:cbranch
        },
        success:function(data){
          var d=JSON.parse(data,false)
          Reload(d)
        },error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    console.log(xhr.responseText);
                  }
      })
    })
    $("#DeleteStudio").on("click",function(){
      dn=$.ajax({
        type:"post",
        url:'{{url("/admin/studio/delete")}}',
        data: {
          _token:'{{ csrf_token() }}',
          id:cstudio
        },
        success:function(data){
          var d=JSON.parse(data,false)
          Reload(d)
        }
      })
    })
    $("#EditStudio").on("click",function(){
      const nama=$("#nama_studio_edit").val()
      const slot=$("#slot_studio_edit").val()
      dn=$.ajax({
        type:"post",
        url:'{{url("/admin/studio/edit")}}',
        data: {
          _token:'{{ csrf_token() }}',
          nama:nama,
          slot:slot,
          id:cstudio
        },
        success:function(data){
          var d=JSON.parse(data,false)
          Reload(d)
        }
      })
    })
    $("#addproducer").on("click",function(){
      const tp=$("#movie_produser").val()
      produser.push(tp)
      $("#movie_produser").val("")
      ReloadProducer()
    })
    $("#adddirektur").on("click",function(){
      const tp=$("#movie_direktur").val()
      director.push(tp)
      $("#movie_direktur").val("")
      ReloadDirector()
    })
    $("#addcast").on("click",function(){
      const tp=$("#movie_cast").val()
      casts.push(tp)
      $("#movie_cast").val("")
      ReloadCast()
    })
    $("#AddStudio").on("click",function(){
      const nama=$("#nama_studio").val();
      const slot=$("#slot_studio").val();
      dn=$.ajax({
        type: "POST",
        url: '{{url("/admin/studio/add")}}',
        data: {
          _token:'{{ csrf_token() }}',
          nama:nama,
          branch:cbranch,
          slot:slot
        },
        success: function(data){
          var d=JSON.parse(data,false)
          Reload(d)
        }
      }); 
    });
    $("#addmovie").on("click",async function(){
      if ($(this).val()=="add") {
        const judul=$("#movie_judul").val();
      const synopsis=$("#synopsis").val();
      const duration=$("#durasi").val()
      if (judul.length>0) {
        if (produser.length>0 && casts.length>0 && director.length>0) {
          if (synopsis.length<=0) {
            alert("sinopsis tidak boleh kosong!")
          } else {
            var addgenre=[]
            genre.forEach(g => {
              if ($("#add_"+g).is(":checked")) {
                addgenre.push(g)
              }
            });
            if (addgenre.length>0) {
              if (duration>0) {
                const img=$("#img")[0].files
                if (img.length>0) {
                  const fd=new FormData()
                  fd.append("_token",'{{ csrf_token() }}')
                  fd.append("synopsis",synopsis)
                  fd.append("duration",duration)
                  fd.append("genre",addgenre.join(", "))
                  fd.append("director",director.join(", "))
                  fd.append("produser",produser.join(", "))
                  fd.append("cast",casts.join(", "))
                  fd.append("image",$("#img").prop("files")[0])
                  fd.append("judul",judul)
                  dn=$.ajax({
                  type: "POST",
                  url: '{{url("/admin/movie/add")}}',
                  data: fd,
                  contentType: false,
                  processData: false,
                  cache:false,
                  dataType: 'html',
                  success: function(data){
                    var d=JSON.parse(data,false)
                    $("#movie_judul").val("")
                    produser=[]
                    director=[]
                    casts=[]
                    ReloadCast()
                    ReloadDirector()
                    ReloadProducer()
                    $("#movie_produser").val("")
                    $("#movie_direktur").val("")
                    $("#movie_cast").val("")
                    $("#durasi").val(0)
                    $("#img").val('')
                    $("#synopsis").val('')
                    addgenre.forEach(g => {
                      $("#add_"+g).prop("checked",false)
                    });
                    ReloadMovie(d)
                    $("#div_add").css("display","none")
                    $("#div_movie").css("display","block")
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    console.log(xhr.responseText);
                  }
                }); 
                } else {
                  alert("poster belum diupload!")
                }
              } else {
                alert("durasi film harus lebih dari 0!")
              }
            }else{
              alert("belum ada genre yang dipilih!")
            }
          }
        } else {
          alert("produser, direktur, dan castnya harus ada!")
        }
      }else{
        alert("judul tidak boleh kosong!")
      }
      }else {
        const judul=$("#movie_judul").val();
      const synopsis=$("#synopsis").val();
      const duration=$("#durasi").val()
      if (judul.length>0) {
        if (produser.length>0 && casts.length>0 && director.length>0) {
          if (synopsis.length<=0) {
            alert("sinopsis tidak boleh kosong!")
          } else {
            var addgenre=[]
            genre.forEach(g => {
              if ($("#add_"+g).is(":checked")) {
                addgenre.push(g)
              }
            });
            if (addgenre.length>0) {
              if (duration>0) {
                const img=$("#img")[0].files
                if (img.length>0) {
                  const fd=new FormData()
                  fd.append("_token",'{{ csrf_token() }}')
                  fd.append("synopsis",synopsis)
                  fd.append("duration",duration)
                  fd.append("genre",addgenre.join(", "))
                  fd.append("director",director.join(", "))
                  fd.append("produser",produser.join(", "))
                  fd.append("cast",casts.join(", "))
                  fd.append("image",$("#img").prop("files")[0])
                  fd.append("judul",judul)
                  fd.append("id",cmov)
                  dn=$.ajax({
                  type: "POST",
                  url: '{{url("/admin/movie/edit")}}',
                  data: fd,
                  contentType: false,
                  processData: false,
                  cache:false,
                  dataType: 'html',
                  success: function(data){
                    var d=JSON.parse(data,false)
                    $("#movie_judul").val("")
                    produser=[]
                    director=[]
                    casts=[]
                    ReloadCast()
                    ReloadDirector()
                    ReloadProducer()
                    $("#movie_produser").val("")
                    $("#movie_direktur").val("")
                    $("#movie_cast").val("")
                    $("#durasi").val(0)
                    $("#img").val('')
                    $("#synopsis").val('')
                    addgenre.forEach(g => {
                      $("#add_"+g).prop("checked",false)
                    });
                    ReloadMovie(d)
                    $("#div_add").css("display","none")
                    $("#div_movie").css("display","block")
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    console.log(xhr.responseText);
                  }
                }); 
                } else {
                  alert("poster belum diupload!")
                }
              } else {
                alert("durasi film harus lebih dari 0!")
              }
            }else{
              alert("belum ada genre yang dipilih!")
            }
          }
        } else {
          alert("produser, direktur, dan castnya harus ada!")
        }
      }else{
        alert("judul tidak boleh kosong!")
      }
      }
    });
    $("#AddBranch").on("click",function(){
      const nama=$("#nama_branch").val();
      if (nama.length>0) {
        dn=$.ajax({
        type: "POST",
        url: '{{url("/admin/branch/add")}}',
        data: {
          _token:'{{ csrf_token() }}',
          nama:nama,
        },
        success: function(data){
          var d=JSON.parse(data,false)
          Reload(d)
        }
      }); 
      } else {
        alert("Nama tidak boleh kosong!");
      }
    });
    $("#deletemovie").on("click",function(){
      console.log(cmov);
      dn=$.ajax({
        type: "POST",
        url: '{{url("/admin/movie/delete")}}',
        data: {
          _token:'{{ csrf_token() }}',
          id:cmov,
        },
        success: function(data){
          ReloadMovie(JSON.parse(data,false))
        }
      }); 
    });
    $('#btnaddmovie').on("click",function(){
      $("#div_add").css("display","block")
      $("#div_movie").css("display","none")
      $("#addmovie").val("add")
      $("#addmovie").text("Tambah Film")
      $("#juduladd").text("Tambah Film Baru")
    })
    $("#accordionExample").on('click','.linkgantinama',function(e){
        const d=$(this).attr("d")
        cbranch=$(this).attr("data-id")
        $("#nama_branch_edit").val(d)
      })
      $("#accordionExample").on('click','.linkeditstudio',function(e){
        const d=$(this).attr("d")
        cstudio=$(this).attr("data-id")
        const slot=$(this).attr("data-slot");
        $("#nama_studio_edit").val(d)
        $("#slot_studio_edit").val(slot)
      })
      $("#accordionExample").on('click','.linkhapusbranch',function(e){
        const d=$(this).attr("d")
        cbranch=$(this).attr("data-id")
        $("#hapusbranchh1").text("Hapus Branch "+d+"?")
      })
      $("#accordionExample").on('click','.linkhapusstudio',function(e){
        const d=$(this).attr("d")
        cstudio=$(this).attr("data-id")
        $("#hapusstudioh1").text("Hapus "+d+"?")
      })
      $("#accordionExample").on('click','.tambahstudio',function(e){
        const d=$(this).attr("d")
        cbranch=$(this).attr("data-id")
        $("#modaladdstudioh5").text("Add new Studio for "+d)
      })
      $("#movsec").on('click','.delmovie',function(e){
        const d=$(this).attr("d")
        cmov=$(this).val()
        $("#modaldeletemovie h4").text("Anda yakin ingin menghapus film "+d)
      })
      $("#btn_search_branch").click(function(){
        const nama=$("#search_branch").val()
        dn=$.ajax({
          type:"get",
          url:"admin/branch/search",
          data:{
            nama:nama
          },success:function(data){
            Reload(JSON.parse(data,false))
          }
        })
      })
</script>
@endsection