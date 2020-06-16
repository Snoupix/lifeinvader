window.onresize = () => {
  if (document.body.clientWidth > 950) {
    $('#signinButton a').addClass('btn-sm')
  }else{
    $('#signinButton a').removeClass('btn-sm')
  }
}

// Restrict image size
var _URL = window.URL || window.webkitURL;
$("#avatar").change(function (e) {
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        var objectUrl = _URL.createObjectURL(file);
        img.onload = function () {
            if(this.width > 1920 || this.height > 1080){
              alert('Tu aura des problèmes si tu upload cette image, elle est trop grande.');
            }
            _URL.revokeObjectURL(objectUrl);
        };
        img.src = objectUrl;
    }
});

// Resize username if too long
if($('.name h1').text().length > 10){
  $('.name h1').css('font-size', '26px')
}



// Search bar

$('#search').click(()=>{
  $('#searchMod')[0].classList.remove('closedSearch')
  $('#searchMod').css("backdrop-filter", "blur(8px)")
  $('#searchBar').focus()
  //$('#go').addClass('fadeIn')
  $('#searchBar').addClass('fadeIn')
})

$('#searchBar').focusout(()=>{
  $('#searchMod')[0].classList.add('closedSearch')
  //$('#go').removeClass('fadeIn')
  $('#searchBar').removeClass('fadeIn')
})

var cssHeight = $(window).height()
$('#searchMod').css("height", cssHeight)


if($('.toastError').length == 1){
  setTimeout(()=>{
    $('.toastError').addClass('fadeOut')
    setTimeout(()=>{
      $('.toastError').remove()
    }, 4000)
  },2000)
}

$('#stalkForm').attr('action', document.URL)
$('#descForm').attr('action', document.URL)
$('.formLike').attr('action', document.URL)
$('#aboutForm').attr('action', document.URL)


var dayList = new Array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
var monthList = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aôut', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
var today = new Date()
var todayDate = today.getDate() 
var todayMin = today.getMinutes()
if(today.getDate().toString().length == 1){
  var todayDate = "0"+today.getDate()
}
if(today.getMinutes().toString().length == 1){
  var todayMin = "0"+today.getMinutes()
}
today = dayList[today.getDay()]+" "+todayDate+" "+monthList[today.getMonth()]+" "+today.getHours()+":"+todayMin

$('input[name="date"]').val(today)


$('#unstalkButton').hover(()=>{
  $('#pstalk').remove()
  $('#unstalkButton').append('<p id="punstalk" style="margin-bottom:0px!important;"><i class="fas fa-times" style="font-size:12px;font-weight:bold;"></i> Unstalk</p>')
},()=>{
  $('#punstalk').remove()
  $('#unstalkButton').append('<p id="pstalk" style="float:right;margin-top:0px;margin-bottom:0px!important;"><i class="fas fa-check" style="font-weight:bold;"></i> Stalking</p>')
})

$('#postBtn').click(()=>{
  $('#postOpen').css('display', 'block')
  $('#postBtn').css('display', 'none')
})

$('#postClose').click(()=>{
  $('#postOpen').css('display', 'none')
  $('#postBtn').css('display', 'block')
})

var modal = $("#modalImage")
var modalImg = document.getElementById("modalImageSrc")
var modalImageCaption = $('#caption')
var author = $('#caption').text()
$('.postImage img').click((e)=>{
  modal.css("display", "block")
  modalImg.src = e.currentTarget.currentSrc;
  if(e.currentTarget.alt != "Post Picture"){
    $('#caption').text(e.currentTarget.alt)
    $('#caption').append('<br/><span style="font-weight:bold;">- '+author+' -</span>')
  }else{
    $('#caption').text(author)
  }

})
$("#closeModalImage").click(()=>{
  modal.css("display", "none")
  $("#caption").text(author)
})
