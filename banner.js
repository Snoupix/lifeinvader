var current_file = files[0];
var reader = new FileReader();
if (current_file.type.indexOf('image') == 0) {
  reader.onload = function (event) {
      var image = new Image();
      image.src = event.target.result;

      image.onload = function() {
        var maxWidth = 1024,
            maxHeight = 1024,
            imageWidth = image.width,
            imageHeight = image.height;


        if (imageWidth > imageHeight) {
          if (imageWidth > maxWidth) {
            imageHeight *= maxWidth / imageWidth;
            imageWidth = maxWidth;
          }
        }
        else {
          if (imageHeight > maxHeight) {
            imageWidth *= maxHeight / imageHeight;
            imageHeight = maxHeight;
          }
        }

        var canvas = document.createElement('canvas');
        canvas.width = imageWidth;
        canvas.height = imageHeight;
        image.width = imageWidth;
        image.height = imageHeight;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(this, 0, 0, imageWidth, imageHeight);

        $('img#apercu').src = canvas.toDataURL(current_file.type);
      }
    }
  reader.readAsDataURL(current_file);
}