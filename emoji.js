const api = 'https://emoji-api.com/emojis?access_key=59ab3c94e6c4850a3fee757a17397f612a5f9ecf'
var table = new Array()

fetch(new Request(api))
.then(response=>response.json())
.then(emojiTable=>{
  for(const x of emojiTable){
    table.push(x)
  }
})
/* .then(()=>{
  $("#postTxt").on("keyup", ()=>{
    setTimeout(()=>{
      var val = $("#postTxt").val().toLowerCase();
      table.forEach(el=>{
        Object.values(el).map((values)=>{
          if(values.includes(val)){
            console.log(el.character)
          }
        })
      })
    }, 500)
  })
}) */
.then(()=>{
  $("#emojiName").on("keyup", ()=>{
    setTimeout(()=>{
      var i = 0
      if(!$("#emojiTable tr").is(':empty')){
        $("#emojiTable tr").remove()
        $("#emojiTable").append('<tr></tr>')
      }
      var val = $("#emojiName").val().toLowerCase();
      table.forEach(el=>{
        Object.values(el).map((values)=>{
          if(values.includes(val)){
            if($("#emojiTable tr:last td:last").text() != el.character){
              $("#emojiTable tr:last").append("<td>"+el.character+"</td>")
              i = i+1 
              if(i > 15){
                $("#emojiTable").append('<tr></tr>')
                i = 0
              }
            }
          }
        })
      })
      $("#emojiTable tr td").click((e)=>{
        var emoji = e.target.innerText
        $('#postTxt').val($('#postTxt').val()+emoji)
      })
    }, 1000)
  })
})

function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

$('#emoji').hover(()=>{
  $('#emoji').css('color', getRandomColor())
  $('#emoji').css('transform', 'scale(1.5)')
}, ()=>{
  $('#emoji').css('color', '#F7E5E5')
  $('#emoji').css('transform', 'scale(1)')
})

$("#emoji").click(()=>{
  $("#emojiWindow").css('display', 'block')
  $("#emojiName").focus()
  $('body').css('overflow-y', 'hidden')
})

$("#closeEmoji").click(()=>{
  $("#emojiWindow").css('display', 'none')
  $('body').css('overflow-y', 'visible')
})
