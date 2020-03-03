<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style type="text/css">
  
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
  </style>
</head>
<body>
  <div class="right_col" role="main">

<h3 class=" text-center">Messaging</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">

              <h4>Tujuan Chat</h4>
               <select name="kontak" id="kontak" class="form-control">
        <?php foreach ($divisi as $tampil) {
          # code...
        ?>
        <option value="<?=$tampil->id_divisi?>"><?=$tampil->nama_divisi?></option>

      <?php }?>
      </select>
       
            </div>
             <button type="button" class="btn btn-primary" id="tujuan" style=" margin-top:20px;margin-left: 15px;">
  New Chat
</button>
           
            
                
          </div>
          <div class="inbox_chat">

            <div class="chat_list " id="">
             <?php foreach ($chat as $tampil) {
               # code...
             ?>

       <a href="#" onclick="detail_chat(<?=$tampil->hash?>)">   <div  id="chat-inbox" class="chat_list active_chat"><div class="chat_people"><div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="chat_ib"><h5><?=$tampil->nama_divisi?> <span class="chat_date">Dec 25</span></h5><p><?=$tampil->pesan?>'</p></div></div></div></a> <?php  }?>
       
            </div>
           
           
          
           
           
           
          </div>
        </div>
        <div class="mesgs" style="display:none;">
         
          <div class="msg_history">
            <div class="incoming_msg">
              <div class="incoming_msg_img">


                
             
            </div>
           <div id="pesan"></div>
          
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="hidden" id="divisi" name="">
              <input type="hidden" id="hash" value="" name="">
              <input type="text" class="write_msg" id="isi" placeholder="Type a message" />
            <!--  <button class="msg_send_btn" type="button" id="send"><i class="fa fa-paper-plane-o" aria-hidden=""></i></button>-->
            </div>
          </div>
        </div>
      </div>
      
      
      
      
    </div>
  </div>
</body>
</html>
<input type="hidden" id="id_divisi" name="" value="<?=$this->session->userdata('divisi');?>">
<script type="text/javascript">
  function detail_chat(hash){

    var hash_id=hash;
    $.ajax({
url:"<?=base_url('User/detail_chat')?>",
type:"POST",
data:{hash_id:hash_id},
dataType:"JSON",
success:function(data){
  var html='';
  for(i=0; i<data.length; i++){
 html +='<div class="incoming_msg"><div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="received_msg"><div class="received_withd_msg"><p>' + data[i].pesan +  '</p></div></div></div>';
 document.getElementById('hash').value=data[i].hash;
 document.getElementById('divisi').value=data[i].id_divisi;
 //document.getElementById('nama').innerHTML=data[i].nama_divisi;
 var element = document.getElementById("chat-inbox");
  element.classList.remove("active_chat");

}
$('.mesgs').show();
document.getElementById('pesan').innerHTML =html;
//$(this).addClass("active_chat");
}


    });
  }
  $(document).ready(function(){
    $("#tujuan").click(function(){
var kontak=$('#kontak').val();
$.ajax({
url:"<?=base_url('User/cek_divisi')?>",
type:"POST",
data:{kontak:kontak},
dataType:"JSON",
success:function(data){

  $('.mesgs').show();
$('#nama').html(data.nama_divisi);
$('#divisi').val(kontak);
$('#pesan').html('');
$('#hash').val(<?=date('hismd');?>);
}

});


    });
   $('#isi').on('keypress', function (e){
         if(e.which === 13){
var isi=$('#isi').val();
var divisi=$('#divisi').val();
var hash=$('#hash').val();
$.ajax({
url:"<?=base_url('user/save_chat')?>",

type:"POST",
data:{divisi:divisi,isi:isi,hash:hash},
dataType:"JSON",
success:function(data){
  //alert(data.chat);
  $('#isi').val('');
var html='';
 var i;
                    for(i=0; i<data.length; i++){
 html +='<div class="incoming_msg"><div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="received_msg"><div class="received_withd_msg"><p>' + data[i].pesan +  '</p><span class="time_date"> 11:01 AM    |    Yesterday</span></div></div></div>';
}
$('#pesan').html(html);
}


});
}

});
  	


  });
  
</script>
<script type="text/javascript">
    $(document).ready(function(){
          $('ul li a').click(function(){
            $('li a').removeClass("active");
            $(this).addClass("active_chat");
        });
    });
</script>