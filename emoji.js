const api = 'https://emoji-api.com/emojis?access_key=59ab3c94e6c4850a3fee757a17397f612a5f9ecf'
var table = new Array()

fetch(new Request(api))
.then(response=>response.json())
.then(emojiTable=>{
  for(const x of emojiTable){
    table.push(x)
  }
})
.then(()=>{
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