<!DOCTYPE html>
<html>
<head>
	<title>Test Assignment</title>
	 <meta name="csrf-token" content="{{ csrf_token()}}">
<link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')}}" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="{{asset('bootstrap/jquery-3.2.1.slim.min.js')}}" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="{{asset('bootstrap/popper.min.js')}}" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{{asset('bootstrap/bootstrap.min.js')}}" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


 <script src="{{asset('jquery/jquery.min.js')}}"></script>



<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
 <script src="{{asset('sweetalert/sweetalert.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">

</head>
<body>
<div class="container page-top">
    <div class="row">
    <div class="col-2"><h3>Your Images</h3></div>
   
  </div>
	<div class="row" id="top-part">
		<div class="col-2"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
     Upload Image
      </button></div>
		<div class="col-10">
			<input type="text" class="live-search-box" placeholder="search here" id="search" />
		</div>
	</div>



        <div class="row" id="gallery">


         
            
            
           
           
       </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="resp"></div>
       <div class="alert alert-danger print-error-msg" style="display:none">
       	 <ul></ul>
       </div>
        <form id="my_form" method="POST" action="{{route('image.upload')}}" enctype="multipart/form-data">
        	    {{ csrf_field() }}
      <div class="modal-body">
        
              
            <input type="file" name="file" id="file">

          
            <div class="upload-area"  id="uploadfile">
              <img src="{{asset('images/drag.png')}}" id="dragdrop_image" height="100px" width="150px">
                <h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
            </div>
           
                      <div class="form-group" id="title-group">
                        <label class="control-label">Title</label>
                       
                            <input type="text" class="form-control input-lg" name="title" value="">
                            
                        
                    </div>
            
                   
                 
                 
                
      </div>
      <div class="modal-footer">
        <button type="submit"class="btn btn-primary">Upload</button>
      </div>
</form>
<div id="upload-progress"><div class="progress-bar"></div></div> <!-- Progress bar added -->
    </div>

  </div>
</div> 
      

    </div>


</body>


<script type="text/javascript">
    $(document).ready(function(){
    $("#gallery").on("focusin", function(){
   $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });


    $(".zoom").hover(function(){
    
    $(this).addClass('transition');
  }, function(){
        
    $(this).removeClass('transition');
  });
});

 });  
</script>

<script type="text/javascript">
    $(document).ready(function(){

    refreshTable();
  
   
 


    $("#my_form").submit(function(event){
    event.preventDefault(); 
    var post_url = $(this).attr("action"); 
    var request_method = $(this).attr("method"); 
    var form_data = new FormData(this); 
    
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data,
        dataType    : 'json',
    contentType: false,
    processData:false,
    xhr: function(){
    //upload Progress
    var xhr = $.ajaxSettings.xhr();
    if (xhr.upload) {
      xhr.upload.addEventListener('progress', function(event) {
        var percent = 0;
        var position = event.loaded || event.position;
        var total = event.total;
        if (event.lengthComputable) {
          percent = Math.ceil(position / total * 100);
        }
      
        $("#upload-progress .progress-bar").css("width", + percent +"%");
      }, true);
    }
    return xhr;
  }
    })
    .done(function(data) {

 if($.isEmptyObject(data.error)){
  $('#gallery').children("div").remove();
  refreshTable();

      var m = "<div class='alert alert-success'>" + data.success + "</div>";
      $('.resp').html(m);
      document.getElementById("my_form").reset();

       setTimeout(function(){
           $("#upload-progress .progress-bar").css("width", + 0 +"%");
           $('.resp').children("div").remove();
            $("#uploadfile").children("div").remove();
           $('#dragdrop_image').css('display','inline');
           $("#uploadfile").append('<h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>');

      }, 3000); 


            

         

        } else {

             printErrorMsg(data.error);

        }





});
  });

     $.ajaxSetup({ cache: false });
 $('#search').keyup(function(){
  $('#gallery').children("div").remove();
 
var searchField = $('#search').val();

  var expression = new RegExp(searchField, "i");

        $.ajax({
                type: 'get',
                url: "{{route('image.refreshTable')}}", 
                dataType: 'json',
                success: function (data) {
                   var image_data='';
                 var i=0;
  $.each(data,function(key,value){
 if (value.title.search(expression) != -1)
   { 
    image_data +='<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
    image_data +='<a href="{{URL::to('/')}}/images/'+value.image+'" class="fancybox" rel="ligthbox">';
    image_data +='<img  src="{{URL::to('/')}}/images/'+value.image+'" class="zoom img-fluid "  alt="">';
   
     image_data +='</a><div class="title"><marquee>'+value.title+'</marquee></div>';

    image_data +='<div class="remove"><a type="button" id="click'+i+'"  ><i class="fa fa-trash-o"></i>Remove</a></div>';
    
                                                   
      image_data += '</div>';                                                                                       
                                                                                
  $(document).on('click', '#click'+i+'', function(){ 
      var csrf_token = $('meta[name="csrf-token"]').attr('content');

    swal({
  title: "Are you sure want to delete?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

 $.ajax({
  url:"{{URL::to('/')}}/delImage/"+key+"",
  type:"post",
  data: {'_method':'DELETE','_token':csrf_token},
  success:function(data){
 
        setTimeout(function(){
            $('#gallery').children("div").remove();
  refreshTable();

      }, 1000); 
     swal("Poof! Your imaginary file has been deleted!", {
      icon: "success",
    });

  },
  error:function(data){
    swal({
      title:'Fail to Delete',
      text: data.error,
      icon:'error',
      timer:'1500'

    })
  }


 });

   
  } else {
    swal("Your imaginary file is safe!");
  }
});

});

i++;
}
  });
  $('#gallery').append(image_data);
                }
            })

 });



});

          function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
             setTimeout(function(){
           $("#upload-progress .progress-bar").css("display","none");
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','none');
             $("#uploadfile").children("div").remove();
           $('#dragdrop_image').css('display','inline');
             $("#uploadfile h1").remove(); 
           $("#uploadfile").append('<h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>');

      }, 3000); 

        }

  function refreshTable(){
      $.ajax({
                type: 'get',
                url: "{{route('image.refreshTable')}}", 
                dataType: 'json',
                success: function (data) {
                   var image_data='';
                 var i=0;
  $.each(data,function(key,value){

    image_data +='<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
    image_data +='<a href="{{URL::to('/')}}/images/'+value.image+'" class="fancybox" rel="ligthbox">';
    image_data +='<img  src="{{URL::to('/')}}/images/'+value.image+'" class="zoom img-fluid "  alt="">';

     image_data +='</a><div class="title"><marquee>'+value.title+'</marquee></div>';

    image_data +='<div class="remove"><a type="button" id="click'+i+'"><i class="fa fa-trash-o">Remove</i></a></div>';
    
                                                   
      image_data += '</div>';                                                                                                                                                                 
  $(document).on('click', '#click'+i+'', function(){ 
      var csrf_token = $('meta[name="csrf-token"]').attr('content');

    swal({
  title: "Are you sure want to delete?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

 $.ajax({
  url:"{{URL::to('/')}}/delImage/"+key+"",
  type:"post",
  data: {'_method':'DELETE','_token':csrf_token},
  success:function(data){
 
        setTimeout(function(){
            $('#gallery').children("div").remove();
  refreshTable();

      }, 1000); 
     swal("Poof! Your imaginary file has been deleted!", {
      icon: "success",
    });

  },
  error:function(data){
    swal({
      title:'Fail to Delete',
      text: data.error,
      icon:'error',
      timer:'1500'

    })
  }


 });

   
  } else {
    swal("Your imaginary file is safe!");
  }
});

});

i++;

  });
  $('#gallery').append(image_data);
                }
            })



  } 
</script>
<script type="text/javascript">
  $(function() {

 
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("h1").text("Drag here");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

   
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

   
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
      $('#dragdrop_image').css('display','none');
     
   
        var fileinput= document.getElementById("file"); 
        var file = e.originalEvent.dataTransfer.files[0];
        fileinput.files = e.originalEvent.dataTransfer.files;

        const dT = new DataTransfer();
        dT.items.add(e.originalEvent.dataTransfer.files[0]);

         fileinput.files = dT.files;
  
         var src= URL.createObjectURL(file);
     
         addThumbnail(src);
    
       
    });

   
    $("#uploadfile").click(function(){
        $("#file").click();
    });

   
    $("#file").change(function(e){
      
        $('#dragdrop_image').css('display','none');
       var fileinput= document.getElementById("file"); 
        var file = e.target.files[0];
        fileinput.files =  e.target.files;
          const dT = new DataTransfer();
          dT.items.add( e.target.files[0]);
          var src= URL.createObjectURL(file);
     
          addThumbnail(src);
    

    });
});




function addThumbnail(data){
    $("#uploadfile h1").remove();  
    $("#uploadfile").append('<div id="thumbnail" class="thumbnail"></div>');
    $("#thumbnail").append('<img src="'+data+'" width="100%" height="78%">');


}

</script>
</html>