window.addEventListener("load", function(){
    
    function UpdateLocality(id){
        deleteCookie('basket');
        setCookie('locality', id); // updating locality
        location.reload(); // перезагружаем страницу
    }
    
    x = document.getElementById("cities_show");
    var selElmnt = x.parentElement.getElementsByClassName('select-items')[0].childNodes;
    ll = selElmnt.length;
    for (j = 0; j < ll; j++) {
        c = selElmnt[j];
        c.addEventListener("click", function(e) {
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
                if (s.options[i].value == this.dataset.id) {
                    UpdateLocality(this.dataset.id);
                    break;
                }
            }
        });
    }


  var cities_show = document.getElementById('cities_show');
  if (cities_show !== undefined && getCookie('locality') !== undefined ){
    cities_show.value = getCookie('locality');
    var evt = document.createEvent("HTMLEvents");
    evt.initEvent("change", false, true);
    cities_show.dispatchEvent(evt);
  }
  
  var cities_footer_links = document.getElementsByClassName('main-cities-collumns')[0];
  if (cities_footer_links !== undefined){
      var cities_columns = cities_footer_links.getElementsByTagName("A");
      if (cities_columns !== undefined){
          for (var index = 0; index < cities_columns.length; index++){
            var city_link = cities_columns[index];
            city_link.addEventListener("click", function(e) {
                UpdateLocality(this.dataset.id);
            });
          }
      }
  }
});