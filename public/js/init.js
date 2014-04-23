$(document).ready(function() {
  $('#shareBtn').tooltip();
  $('.share > .trigger').popover({
    html : true,
    title: function() {
      return $(this).parent().find('.head').html();
    },
    content: function() {
      return $(this).parent().find('.content').html();
    },
    container: 'body',
    placement: 'top'
  });

  $('.share > .trigger').click(function(){
      $('.share > .trigger').not(this).popover('hide');
  });
  
  $('body').on('hidden.bs.modal', '.modal', function () {
      $(this).removeData('bs.modal');
  });

  $('div.cover').each(function(){
    var $obj = $(this);
    $(window).scroll(function() {
      var yPos = -($(window).scrollTop() / $obj.data('speed'));
      var bgpos = '50% '+ yPos + 'px';
      $obj.css('background-position', bgpos );
    });
  });

  $.fn.deleteModel = function(model, ajax, hideElement){
    var o = $(this[0]);
    if (!confirm('Vai tiešām vēlies dzēst '+ model +' ?')){
      return;
    } if (ajax == true){
      $.ajax({
        invokedata : {obj: o},
        type     : 'DELETE',
        url      : o.attr('href'),
        beforeSend: function() {
          $('#processing').modal('show');
        },
        success  : function(result) {
          if(result.success == true){
             // var obj = this.invokedata.obj;
             // obj.parents(hideElement).fadeOut();
             location.reload();
          } else {
             alert('Nevarēju idzēst '+ model +'. Lūdzu mēģiniet vēlreiz.');
          }
          $('#processing').modal('hide');
        }
      });
    } else {
      o.append(function(){
      return "\n"+
       "<form id='deleteForm' action='"+o.attr('href')+"' method='POST' style='display:none'>\n"+
       "<input type='hidden' name='_method' value='delete'>\n"+
       "</form>\n";
      });
      $('#deleteForm', o).submit();
    }
    return;
  }

});

var tweet = function(url, text) {
  window.open( "http://twitter.com/share?url=" + 
  encodeURIComponent(url) + "&text=" + 
  encodeURIComponent(text) + "&count=none/", 
  "tweet", "height=300,width=550,resizable=1" )
}
var postToFb = function(url) {
  window.open( "http://www.facebook.com/sharer.php?u=" + 
  encodeURIComponent(url),
  "post", "height=300,width=550,resizable=1" )
}
var shareOnGp = function(url) {
  window.open( "https://plus.google.com/share?url=" + 
  encodeURIComponent(url),
  "post", "height=300,width=550,resizable=1" )
}