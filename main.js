$(document).ready(()=>{

  console.log('%c Hey, ce site a été créé par :', 'font-weight: bold; font-size: 20px;color: red')
  console.log('%c <Snoupix/> ', 'font-weight: bold; font-size: 40px;color: red; text-shadow: 3px 3px 0 rgb(217,31,38) , 6px 6px 0 rgb(226,91,14) , 9px 9px 0 rgb(245,221,8) , 12px 12px 0 rgb(5,148,68) , 15px 15px 0 rgb(2,135,206) , 18px 18px 0 rgb(4,77,145) , 21px 21px 0 rgb(42,21,113)')
  console.log('%c Tu peux le contacter via Discord', 'font-weight: bold; font-size: 15px;color: rgb(245,221,8)')
  console.log('%c Snoupix#1264', 'font-weight: bold; font-size: 18px;color: rgb(5,148,68)')

  setTimeout(()=>{
    if(document.body.clientWidth > 1201){
      $('#postTxt').attr('cols', '70')
      $('#wall').attr('class', 'col-6 wall')
      $('#ads').attr('class', 'col-3 ads')
    }else if(document.body.clientWidth > 993){
      $('#postTxt').attr('cols', '55')
      $('#wall').attr('class', 'col-9 wall')
      $('#ads').attr('class', 'col-12 ads')
    }else if(document.body.clientWidth > 771){
      $('#wall').attr('class', 'col-9 wall')
      $('#ads').attr('class', 'col-12 ads')
      $('#postTxt').attr('cols', '38')
    }else if(document.body.clientWidth > 420){
      $('#postTxt').attr('cols', '25')
    }else{ // Phone size
      $('#postTxt').attr('cols', '30')
      $('#postTxt').attr('rows', '2')
      $('#wall').attr('class', 'col-9 wall')
      $(".postFooter span").css("font-size", "8px")
      $(".postFooter span").css("margin-top", "5px")
      $(".postBanner span").css("font-size", "8px")
      $('.borderPic').css("padding", "0px")
      $('.borderPic').css("margin", "0px")
      $('.borderPic').css("border", "none")
      $('.profilePic').css("height", "192px")
      $('.profilePic img').css("height", "100%")
      $('.profilePic img').css("width", "100%")
      $('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" ? $('.profilePic img').attr('src', './assets/default.png') : ''
      $(".commenter").css("font-size", "9px")
      $(".commenter").css("padding", "3px")
      $(".borderPic").attr("class", 'borderPic col-12')
      $("header .col-8").attr("class", 'col-12')
      $("header .col-12").css('padding-top', '24px')
      $(".banner").attr('class', 'row banner bannerPhone')
      $(".description .col-12").attr('class', 'col-8')
      $(".description .col-8").css('padding-top', '0px')
      $('button[name="edit"]').css('margin-right', '10px')
      $(".about p").css('font-size', '10px')
      $("#signinButton").css('margin-top', '3%')
      $(".name h1").css('margin-top', '10px')
      $(".name h1").css('margin-bottom', '10px')
      $("#stalkForm button").css('margin-right', '15px')
      $(".carousel-item img").css('margin', '60px auto')
      $('input[name="postSub"]').css('right', '0px')
      $(".posts").attr('class', 'col-12 posts')
      $(".ads").attr('class', 'col-12 ads')
      $(".row .name").attr('class', 'col-8 name')
      $('.ad img').attr('width', '220px')
      $('.postBanner span').css('margin-top', '-9px')
      $('.postBanner span').css('margin-right', '-5px')
      $('#commentForm textarea').attr('cols', '35')
      $('#commentForm textarea').attr('rows', '2')
      $('#unstalkButton').css('margin-right', '6px')
      $('#postClose').css('margin-right', '20px')
      $('input[name="postSub"]').css('bottom', '-27px')
      $("#imagesMod #carouselIndicators").css('margin-top', '50px')
      $(".xDelete").css('margin-top', '21px')
      $(".xDelete").css('margin-right', '2px')
      $('#deletePost').css('top', '25%')
      $('#deletePost').css('left', '4.5%')
      $(".about .col-12").css('padding-right', '0px')
      $("#signinButton a").css('margin-top', '3px')
      $('hr').css('margin-top', '0.7rem')
      $('hr').css('margin-bottom', '0.7rem')
      $('.postImage img').css('width', '60%')
      if(!$('textarea[name="postTxt"]').length){$(".bannerPhone").css('margin-bottom', '30px')}
      for(let e of $(".post")){
        if(e.childNodes[0].childNodes[1].innerText.length > 10){
          e.childNodes[0].childNodes[1].style.fontSize = '14px'
        }
      }
      for(let c of $(".comment")){
        if(c.childNodes[0].childNodes[1].innerText.length > 10){
          c.childNodes[0].childNodes[1].style.fontSize = '9px'
        }
        if(c.childNodes[0].childNodes[1].innerText.length > 6 && c.childNodes[0].childNodes[1].innerText.length < 10){
          c.childNodes[0].childNodes[1].style.fontSize = '13px'
        }
      }
    }

    // Center default pic
    if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth > 1200){
      $('.profilePic img').css('padding-left', '50px')
    }else if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth < 1200 && document.body.clientWidth > 990){
      $('.profilePic img').css('padding-left', '30px')
    }else if($('.profilePic img').attr('src') == "./assets/usersAvatar/default.png" && document.body.clientWidth < 990){
      $('.profilePic img').css('padding-left', '0px')
    }

    $('#searchMod').css("height", $(this).height())

  },700)
})


hasTouch = () => {
  return 'ontouchstart' in document.documentElement
         || navigator.maxTouchPoints > 0
         || navigator.msMaxTouchPoints > 0;
}
if(hasTouch()){ // remove all the :hover stylesheets
  try { // prevent exception on browsers not supporting DOM styleSheets properly
    for(var si in document.styleSheets){
      if(!si.href.startsWith('http://')){
        console.log('yes')
        console.log(si)
      }
      var styleSheet = document.styleSheets[si];
      //if (!styleSheet.rules) continue;

      for(var ri = styleSheet.rules.length - 1; ri >= 0; ri--){
        if(!styleSheet.rules[ri].selectorText) continue;

        if(styleSheet.rules[ri].selectorText.match(':hover')){
          styleSheet.deleteRule(ri);
        }
      }
    }
  }catch(err){/* console.error(err) */}
}


window.onresize = () => {
  if (document.body.clientWidth > 950) {
    $('#signinButton a').addClass('btn-sm')
  }else{
    $('#signinButton a').removeClass('btn-sm')
  }

  // Responsive
  if(document.body.clientWidth > 1201){
    $('#postTxt').attr('cols', '70')
    $('#wall').attr('class', 'col-6 wall')
    $('#ads').attr('class', 'col-3 ads')
  }else if(document.body.clientWidth > 993){
    $('#postTxt').attr('cols', '55')
    $('#wall').attr('class', 'col-9 wall')
    $('#ads').attr('class', 'col-12 ads')
  }else if(document.body.clientWidth > 771){
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
            if(this.width < 1920 || this.height < 1080){
              alert('Tu peux avoir des problèmes si tu upload cette image, utilises-en une de 1920 x 1080 px si tu veux que ce soit optimal.')
            }
            _URL.revokeObjectURL(objectUrl)
        }
        img.src = objectUrl
    }
})

$("#profilePic").change(()=>{
    var file, img
    if ((file = this.files[0])) {
        img = new Image()
        var objectUrl = _URL.createObjectURL(file)
        img.onload = function () {
            if(this.width < 1920 || this.height < 1080){
              alert('Tu peux avoir des problèmes si tu upload cette image, utilises-en une de 1920 x 1080 px si tu veux que ce soit optimal.')
            }
            _URL.revokeObjectURL(objectUrl)
        };
        img.src = objectUrl
    }
})


if(window.location.pathname == '/signup.php'){
  $('input[name="createdTime"]').val((new Date().getMinutes().toString().length == 1) ? "0"+new Date().getMinutes() : new Date().getMinutes())
  setInterval(()=>{
    $('input[name="createdTime"]').val((new Date().getMinutes().toString().length == 1) ? "0"+new Date().getMinutes() : new Date().getMinutes())
  }, 30000) // 30 s
}


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
$('#focusout').css('height', $(this).height())
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

var commentaire = $("#commentModal")
var id
$('.commenter').click((e)=>{
  if(window.location.pathname == "/index.php"){
    id = e.currentTarget.parentElement.childNodes[0].value
  }else{
    id = e.currentTarget.parentElement.childNodes[2].value
  }
  commentaire.css("display", "block")
  $("#commentModal textarea").focus()
})
$('#closeCommentModal').click(()=>{
  commentaire.css("display", "none")
  $("#commentModal textarea").val("")
})

$('.xDelete').click((e)=>{
  $('#deletePost').css('display', 'block')
  $('body').css('scroll', 'none')
  $('#idDeletePost').val(e.currentTarget.parentElement.parentElement.parentElement.lastChild.childNodes[1].childNodes[0].value)
})

$('#closeDeletePost').click(()=>{
  $('#deletePost').css('display', 'none')
  $('body').css('scroll', 'auto')
})

$('.stalkers').click(()=>{
  $('#stalkersMod').css('display', 'block')
})

$('#outerStalk').click(()=>{
  $('#stalkersMod').css('display', 'none')
})

$('.likes').click(e=>{
  if(window.location.pathname == "/index.php"){
    var postID = e.currentTarget.parentElement.childNodes[0].value
  }else{
    var postID = e.currentTarget.parentElement[1].value
  }
  for(let el of $('.likeName')){
    for(let list of el.classList){
      if(list != postID){
        el.style.display = "none"
      }else{
        el.style.display = "block"
      }
    }
  }
  $(".noLike").remove()
  var i = 0
  for(let el of $('.likeName')){
    if(el.style.display == "block"){
      i = i+1
    }
  }
  if(i == 0){
    $("#likeDiv").append('<p class="noLike">Personne n\'a like ce post</p>')
  }
  $('#likesMod').css('display', 'block')
})

$('#outerLike').click(()=>{
  $('#likesMod').css('display', 'none')
})

function submitComm(){
  $("#commentID").val(id)
  $("#dateComm").val(today)
  if($("#commentModal textarea").val().length > 1){
    $("#commentForm").submit()
  }
}

$('#bgImage').on('change', ()=>{
  /* $('#formBgImage').submit() */
  $('#bannerSub').click()
})
