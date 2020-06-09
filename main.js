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

$('#stalkForm').attr('action', document.URL);
$('#descForm').attr('action', document.URL);
$('.formLike').attr('action', document.URL);


$('#unstalkButton').hover(()=>{
  $('#pstalk').remove();
  $('#unstalkButton').append('<p id="punstalk" style="margin-bottom:0px!important;"><i class="fas fa-times" style="font-size:12px;font-weight:bold;"></i> Unstalk</p>');
},()=>{
  $('#punstalk').remove();
  $('#unstalkButton').append('<p id="pstalk" style="float:right;margin-top:0px;margin-bottom:0px!important;"><i class="fas fa-check" style="font-weight:bold;"></i> Stalking</p>');
})