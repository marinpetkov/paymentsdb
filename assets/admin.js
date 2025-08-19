(function($){
  $(function(){
    var $search = $('#bs-search');
    var $rows   = $('#bs-table tbody tr');

    function applyFilter(){
      var q = ($search.val() || '').toLowerCase().trim();
      if(!q){ $rows.show(); return; }
      $rows.each(function(){
        var hay = ($(this).attr('data-search') || '').toLowerCase();
        $(this).toggle(hay.indexOf(q) !== -1);
      });
    }

    $search.on('input', applyFilter);
  });
})(jQuery);
