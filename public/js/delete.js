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