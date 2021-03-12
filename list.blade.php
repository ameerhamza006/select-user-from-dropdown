@extends('admin.layout.app')
@section('content')
@if(Session::has('message'))
<div class="alert alert-success">{{Session::get('message')}}</div>

@endif
<p id="alert"></p>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" type="text/css" >
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>




<div class="card" id="myTable">




              <div class="card-header">
             
                <div class="form-group row">
                    
                    <div class="col-lg-3">
                    <select class="form-control dynamic" id="user" data-dependent="location" name="user" >
                     <option >All</option>
                     @foreach($users as $user)
                   
                     <option value="{{$user->id}}">{{$user->f_name}} {{$user->company}}</option>
                     
                     @endforeach
                     </select>
                    </div>
                    <div class="col-lg-5">
                        </div>
                 <div class="col-lg-4">
                    
                     <h6><b>Available Balance </b> : <p id="available">{{$Avalible}}</p></h6>
                     </div>
                     
                     
                 
                  </div>
                  

                 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>User</th>
                     <th>Comapany</th>
                    <th>Type</th>
                    <th>Cost</th>
                    <th>Remarks</th>
                    
                  
                    <th>Date</th>
                   
                  </tr>
                  </thead>
                  <tbody class="dynamic" id="location">
                      @foreach($cradits as $item)
                  <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->f_name}}</td>
                     <td>{{$item->company}}</td>
                    <td>{{$item->credit}}</td>
                    <td>{{$item->cost}}</td>
                    <td>{{$item->remarks}}</td>
                    
                  
                    <td>{{$item->date}}</td>
                   
                  </tr>
                  @endforeach
                  </tbody>
                
                </table>
                 {{$cradits->links()}}
              <!-- /.card-body -->
              <style>
                  
                  .w-5{
                      display:none;
                  }
                  
              </style>
              </div>
              
              <!-- /.card-body -->
            </div>
@endsection
@section('scripts')


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <script>

$(document).ready(function(){

 $('.dynamic').change(function(){
    
  if($(this).val() != '')
  {
   var select = $(this).val();
  
   var value = $(this).val();
   var dependent = $(this).data('dependent');
   var _token = $('input[name="_token"]').val();
   $.ajax({
    url:"{{ route('ReportController.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:"{{csrf_token()}}", dependent:dependent},
    success:function(result)
    {
        
      var location = '';
      //var available = '';
    var d = result['data'];
     var available = result['available'];
        $('#location').empty()
        
       // $('#remark').empty()                 
    $.each(d,function(i,result){
        
      //  location += '<option value="'+result.screen_id+'">"'+result.screen_location+'"</option>'
        
        
        location += '<tr>'+
                    '<td>'+result.id+'</td>' +
                    '<td>'+result.f_name+'</td>' +
                    '<td>'+result.company+'</td>' +
                    '<td>'+result.credit+'</td>' +
                    '<td>'+result.cost+'</td>' +
                    '<td>'+result.remarks+'</td>' +
                   
                    '<td>'+result.date+'</td>' +
                   
                  '</tr>'
        
        
        
        
       // remark += '<option value="'+result.id+'">"'+result.name+'"</option>'
        $('#location').html(location)
        $('#available').html(available)
        
    })
    }

   })
  }
 });

 $('#user').change(function(){
  $('#location').val('');
  $('#remark').val('');
 });

 $('#location').change(function(){
  $('#remark').val('');
 });
 

});
</script>

  
  
  






<script>




 
$(document).ready( function () {
    $('#myTable').DataTable();
} );





















  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
    $(document).ready(function(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })
    
    $('#deleteBtn').click(function(){
              var id = $(this).data("id")

      $.ajax({
        type:'Delete',
        url:'status/'+id,
        data:{
          "_token": "{{ csrf_token() }}",
          "id":id
        },
        success:function(response){
        
          
          $('#alert').html(response)
        }
      })
    })


  })
 
</script>
@endsection