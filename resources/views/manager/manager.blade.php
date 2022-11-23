@extends('master.masterlayout')

@section('body')
<x-sidebarmanager></x-sidebarmanager>
    <div>
        <div id="div_dashboard" style="display:block">
            @include('manager.dashboard')
        </div>
        <div id="div_report" style="display:none">
            @include('manager.report')
        </div>
    </div>
@endsection
@section('pageScript')
    <script>
        $(document).ready(function(){

        });

        var current = 0;
        const page = ["dashboard", "report"];
        
        function PageChange(e){
            current = $(e.target).attr("target");
            for(let i = 0; i < page.length; i++){
                const p = page[i];
                if(i == current){
                    $('#nav_'+p).addClass("active");
                    $('#div_'+p).css("display","block");
                }
                else{
                    $('#nav_'+p).removeClass("active");
                    $('#div_'+p).css("display","none");
                }
            }
        }
    </script>
@endsection