$(document).ready(()=>{
  setTimeout(()=>{
    if(document.body.clientWidth > 1201){
      $('#postTxt').attr('cols', '70')
      $('#ads img').css('width', '100%')
      $('#wall').attr('class', 'col-6 wall')
      $('#ads').attr('class', 'col-3 ads')
    }else if(document.body.clientWidth > 993){
      $('#postTxt').attr('cols', '55')
      $('#ads img').css('width', '220px')
      $('#wall').attr('class', 'col-9 wall')
      $('#ads').attr('class', 'col-12 ads')
    }else if(document.body.clientWidth > 771){
      $('#ads img').css('width', '220px')
      $('#wall').attr('class', 'col-9 wall')
      $('#ads').attr('class', 'col-12 ads')
      $('#postTxt').attr('cols', '38')
    }else if(document.body.clientWidth > 401){
      $('#postTxt').attr('cols', '25')
    }else{ // Phone size
      $('#postTxt').attr('cols', '20')
      $('#postTxt').attr('rows', '3')
    }

    // Center default pic
    if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth > 1200){
      $('.profilePic img').css('padding-left', '50px')
    }else if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth < 1200 && document.body.clientWidth > 990){
      $('.profilePic img').css('padding-left', '30px')
    }else if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth < 990){
      $('.profilePic img').css('padding-left', '0px')
    }

  },700)
})



window.onresize = () => {
  if (document.body.clientWidth > 950) {
    $('#signinButton a').addClass('btn-sm')
  }else{
    $('#signinButton a').removeClass('btn-sm')
  }

  // Responsive
  if(document.body.clientWidth > 1201){
    $('#postTxt').attr('cols', '70')
    $('#ads img').css('width', '100%')
    $('#wall').attr('class', 'col-6 wall')
    $('#ads').attr('class', 'col-3 ads')
  }else if(document.body.clientWidth > 993){
    $('#postTxt').attr('cols', '55')
    $('#ads img').css('width', '220px')
    $('#wall').attr('class', 'col-9 wall')
    $('#ads').attr('class', 'col-12 ads')
  }else if(document.body.clientWidth > 771){
    $('#ads img').css('width', '220px')
    $('#wall').attr('class', 'col-9 wall')
    $('#ads').attr('class', 'col-12 ads')
    $('#postTxt').attr('cols', '38')
  }else if(document.body.clientWidth > 401){
    $('#postTxt').attr('cols', '25')
  }else{ // Phone size
    $('#postTxt').attr('cols', '20')
    $('#postTxt').attr('rows', '3')
  }

  if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth > 1200){
    $('.profilePic img').css('padding-left', '50px')
  }else if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth < 1200 && document.body.clientWidth > 990){
    $('.profilePic img').css('padding-left', '30px')
  }else if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth < 990){
    $('.profilePic img').css('padding-left', '0px')
  }
  
}

// Restrict image size
var _URL = window.URL || window.webkitURL
$("#avatar").change(function (e) {
    var file, img
    if ((file = this.files[0])) {
        img = new Image()
        var objectUrl = _URL.createObjectURL(file)
        img.onload = function () {
            if(this.width > 1920 || this.height > 1080){
              alert('Tu aura des problèmes si tu upload cette image, elle est trop grande.')
            }
            _URL.revokeObjectURL(objectUrl)
        }
        img.src = objectUrl
    }
})

$("#profilePic").change(function (e) {
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
  $('#searchBar').addClass('fadeIn')
})

$('#searchBar').focusout(()=>{
  $('#searchMod')[0].classList.add('closedSearch')
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
  $('.pstalk').remove()
  $('#unstalkButton').append('<p class="punstalk" style="margin-bottom:0px!important;"><i class="fas fa-times" style="font-size:12px;font-weight:bold;"></i> Unstalk</p>')
},()=>{
  $('.punstalk').remove()
  $('#unstalkButton').append('<p class="pstalk" style="float:right;margin-top:0px;margin-bottom:0px!important;"><i class="fas fa-check" style="font-weight:bold;"></i> Stalking</p>')
})

$('#postBtn').click(()=>{
  $('#postOpen').css('display', 'block')
  $('#postBtn').css('display', 'none')
})

$('#postClose').click(()=>{
  $('#postOpen').css('display', 'none')
  $('#postBtn').css('display', 'block')
})

if(window.location.pathname == "index.php"){
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
}else{ // Dashboard
  var modal = $("#modalImage")
  var modalImg = document.getElementById("modalImageSrc")
  var modalImageCaption = $('#caption')
  $('.postImage img').click((e)=>{
    var author = e.target.parentElement.parentElement.children[0].children[1].innerText
    modal.css("display", "block")
    modalImg.src = e.currentTarget.currentSrc;
    if(e.currentTarget.alt != "Post Picture"){
      $('#caption').text(e.currentTarget.alt)
      $('#caption').append('<br/><span style="font-weight:bold;">- '+author+' -</span>')
    }else{
      $('#caption').text(author)
    }
  })
}
$('#focusout').css('height', cssHeight)
$("#focusout").click(()=>{
  modal.css("display", "none")
})
$("#closeModalImage").click(()=>{
  modal.css("display", "none")
  $("#caption").text(author)
})


var modal2 = $("#imagesMod")
var modalImg2 = document.getElementById("imagesModeSrc")
var modalImageCaption = $('#caption')
var author2 = $('#caption').text()
$('.toggleImageDiv').click((e)=>{
  modal2.css("display", "block")
})
$("#closeimagesMod").click(()=>{
  modal2.css("display", "none")
  $("#caption").text(author2)
})

$('#filter').on('change', ()=>{
  // VOIR LES GENS STALKED
  if($('#filter').val() == 'stalked'){
    $('.notStalking').css('display', 'none')
    $('.notStalking').css('visibility', 'hidden')
  }else{// TOUT VOIR
    $('.notStalking').css('display', 'block')
    $('.notStalking').css('visibility', 'visible')
  }
})

for(let e of document.getElementsByClassName('post')){
  //console.log(e)
  if(e > 25){
    // place a limit
  }
}

$('.displayComms').click((e)=>{
  if(window.location.pathname == "/index.php"){
    var postval = '.id'+e.currentTarget.parentElement[0].value
  }else{
    if($('#signinButton a').text() == "Sign in"){
      var postval = '.id'+e.currentTarget.parentElement.childNodes[1].value
    }else{
      var postval = '.id'+e.currentTarget.parentElement.childNodes[2].value
    }
  }
  if($(postval).css('display') == 'none'){
    e.currentTarget.childNodes[0].classList.replace('fa-chevron-down', 'fa-chevron-up')
    e.currentTarget.childNodes[3].classList.replace('fa-chevron-down', 'fa-chevron-up')
    $(postval).css('display', 'block')
  }else{
    e.currentTarget.childNodes[0].classList.replace('fa-chevron-up', 'fa-chevron-down')
    e.currentTarget.childNodes[3].classList.replace('fa-chevron-up', 'fa-chevron-down')
    $(postval).css('display', 'none')
  }
})