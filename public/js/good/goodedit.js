function submitedit(id) {
  var str_data1 = $('#goodedit').serialize();
  $.ajax({
    type: "POST",
    url: "/good/" + id + "/edit",
    data: str_data1,
    success: function (msg) {
      confirm("fuck");
    }

  });

}

function preview(file) {
  var prevDiv = document.getElementById('preview');
  if (file.files && file.files[0]) {
    var prreader = new FileReader();
    var reader = new FileReader();
    reader.onload = function (evt) {
      prevDiv.innerHTML = '<img id="goodimgpreview" src="' + evt.target.result + '" />';
      $('#goodimgpreview').cropper({
        aspectRatio: 16 / 9,
        crop: function (e) {
          $("#goodTitleUploadCpX").val(e.x);
          $("#goodTitleUploadCpY").val(e.y);
          $("#goodTitleUploadCpWidth").val(e.width);
          $("#goodTitleUploadCpHeight").val(e.height);
        }
      });
    };
    prreader.onload = function (evt) {
      var fileBuf = new Uint8Array(evt.target.result.slice(0, 11));
      var mime = isImage(fileBuf);
      if (mime == null) {
        //This should be modified
        alert("Please open image!");
        return;
      }
      else {
        reader.readAsDataURL(file.files[0]);
      }
    };
    prreader.readAsArrayBuffer(file.files[0]);
  }
  else {
    prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
  }
}