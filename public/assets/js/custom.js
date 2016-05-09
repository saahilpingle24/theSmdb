$(document).ready(function($) {  

  //tooltip or surprise me link
  $('[data-toggle="tooltip"]').tooltip();   

  //typeahead.js for user search and movie search using tmdb api
  var engine = new Bloodhound({        
    remote: {
      url: '../query?user=%QUERY%',
      wildcard: '%QUERY%'
    },
    datumTokenizer: Bloodhound.tokenizers.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace
  });

  var tmdbEngine = new Bloodhound({        
    remote: {
      url: 'https://api.themoviedb.org/3/search/movie?query=%QUERY%&api_key=6fbeda5037c76d85a8ebcc1bbadfd38a',
      wildcard: '%QUERY%',
      filter: function(movies) {            
        return $.map(movies.results, function (movie) {
          return {
            id: movie.id,
            value: movie.original_title,
            year: (movie.release_date.substr(0, 4) ? movie.release_date.substr(0, 4) : ''),
            poster: (movie.poster_path ? 'https://image.tmdb.org/t/p/w300/'+movie.poster_path : 'http://www.poweraidus.com/poweraidus/wp-content/uploads/2013/12/movie_poster_blank.jpg')
          };
        });
      }
    },
    datumTokenizer: Bloodhound.tokenizers.whitespace('movie'),
    queryTokenizer: Bloodhound.tokenizers.whitespace
  });

  engine.initialize();
  tmdbEngine.initialize();

  $("#users").typeahead({
    hint: true,
    highlight: true,
    minLength: 2
  }, {
    source: engine.ttAdapter(),        
    name: 'User_list',        
    displayKey: 'name',
    valueKey: 'id',
    templates: {
      empty: [
      '<div class="empty-message">unable to find any</div>'
      ]
    }
  });

  $("#movies").typeahead({
    hint: true,
    highlight: true,
    minLength: 2
  }, {
    name: 'Movie_list',      
    valueKey: 'id',
    displayKey: 'value',
    source: tmdbEngine.ttAdapter(),        
    templates: {
      empty: [
      '<div class="empty-message">unable to find any</div>'
      ].join('\n'),suggestion: Handlebars.compile('<p><img src={{poster}} class=\"search-poster\"><strong> {{value}}</strong> ({{year}})</p>')    
    }
  });

  $('textarea#expand').focus(function () {
    $(this).animate({ height: "6em" }, 500);
    $("#comment_submit").fadeIn(2500);      
  });

  $('.article').readmore({
    speed: 75,
    collapsedHeight: 100,
    heightMargin: 16,
    lessLink: '<a href="#">Read less</a>'
  });

  $('.review').readmore({
    speed: 75,
    collapsedHeight: 80,
    heightMargin: 16,
    lessLink: '<a href="#">Read less</a>',
    afterToggle: function(trigger, element, expanded) {
      if(! expanded) {    
        $('html, body').animate( { scrollTop: element.offset().top }, {duration: 100 } );
      }
    }
  });

  $.fn.stars = function() {
    return $(this).each(function() {        
      var val = parseFloat($(this).html())/2;        
      var size = Math.max(0, (Math.min(5, val))) * 16;        
      var $span = $('<span />').width(size);        
      $(this).html($span);
    });
  }

  $(function() {
    $('span.stars').stars();
  });
  
});

function checkInput() {
    event.preventDefault();    
    var movie_id = $("#movie_id").val();
    if(movie_id=="") {
      alert("Seach for a movie first!");
    } else {
      $('form#movie-search').submit();      
    }
}


$(document).ready(function() {
   (function($, window, document){
    var panelSelector = '[data-perform="panel-collapse"]';

    $(panelSelector).each(function() {
      var $this = $(this),
      parent = $this.closest('.panel'),
      wrapper = parent.find('.panel-wrapper'),
      collapseOpts = {toggle: false};

      if( ! wrapper.length) {
        wrapper =
        parent.children('.panel-heading').nextAll()
        .wrapAll('<div/>')
        .parent()
        .addClass('panel-wrapper');
        collapseOpts = {};
      }
      wrapper
      .collapse(collapseOpts)
      .on('hide.bs.collapse', function() {
        $this.children('i').removeClass('fa-minus').addClass('fa-plus');
      })
      .on('show.bs.collapse', function() {
        $this.children('i').removeClass('fa-plus').addClass('fa-minus');
      });
    });
    $(document).on('click', panelSelector, function (e) {
      e.preventDefault();
      var parent = $(this).closest('.panel');
      var wrapper = parent.find('.panel-wrapper');
      wrapper.collapse('toggle');
    });
  }(jQuery, window, document));

  /** ******************************
   * Remove Panels
   * [data-perform="panel-dismiss"]
   ****************************** **/
   (function($, window, document){
    var panelSelector = '[data-perform="panel-dismiss"]';
    $(document).on('click', panelSelector, function (e) {
      e.preventDefault();
      var parent = $(this).closest('.panel');
      removeElement();

      function removeElement() {
        var col = parent.parent();
        parent.remove();
        col.filter(function() {
          var el = $(this);
          return (el.is('[class*="col-"]') && el.children('*').length === 0);
        }).remove();
      }
    });
  }(jQuery, window, document));

 });

$.fn.serializeObject = function()
{
  var o = {};
  var a = this.serializeArray();
  $.each(a, function() {
    if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });
  return o;
};

$(document).ready(function(){
  $('.submission').submit(function(event){    
    event.preventDefault();    
    $.ajax({
      url: '/collection/movie',
      type: "post",
      data: $(this).serializeObject(),      
      success: function(data) {        
        $("#add-success-message").html(data);          
        $("#add-success-status").slideDown(500);   
        $("#add-success-status").fadeTo(1000, 500).slideUp(500);   
      } 
    });        
  });
});

$(document).ready(function()
    {
      $("#notificationLink").click(function()
      {
        $("#notificationContainer").fadeToggle(300);
        $("#notification_count").fadeOut("slow");
        return false;
      });

//Document Click
$(document).click(function()
{
  $("#notificationContainer").hide();
});
//Popup Click
$("#notificationContainer").click(function()
{
  return false
});

});

$('#myCarousel').carousel({
  interval: 2500
});

$('#carousel-text').html($('#slide-content-0').html());

// When the carousel slides, auto update the text
$('#myCarousel').on('slid.bs.carousel', function (e) {
  var id = $('.item.active').data('slide-number');
  $('#carousel-text').html($('#slide-content-'+id).html());
});