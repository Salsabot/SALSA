var $messages = $('.messages-content'),
    d, h, m,
    i = 0;

$(window).load(function() {
  $messages.mCustomScrollbar();
    welcomeMessage();
});

function updateScrollbar() {
  $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
    scrollInertia: 10,
    timeout: 0
  });
}

function speak(txt) {
	
	$.speech({
            key: '2f969919cc424d09b0b89fd63cb2aef5',
            src: txt,
            hl: 'en-us',
            r: 0, 
            c: 'mp3',
            f: '16khz_16bit_mono',
            ssml: false
        });
}

function setDate(){
  d = new Date();
  if (m !== d.getMinutes()) {
    m = d.getMinutes();
    $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
  }
}

function insertMessage() {
  msg = $('.message-input').val();
  if ($.trim(msg) == '') {
    return false;
  }
  $('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
  setDate();
  $('.message-input').val(null);
  updateScrollbar();
  var dataString = 'q='+msg;
  $.ajax({
      type: "POST",
      url: "apiserver/chat.php",
      data: dataString,
      success: function(rdata) { 
		
		speak(rdata);
      $('<div class="message new"><figure class="avatar"><img src="images/avatar.jpeg" /></figure>' +rdata+'</div>').appendTo($('.mCSB_container')).addClass('new');
      updateScrollbar();
	  },
      error: function(){
		  var emsg = 'there seems to be a problem with the server. Please try again.';
		  speak(emsg);
      $('<div class="message new"><figure class="avatar"><img src="images/avatar.jpeg" /></figure>'+emsg+'</div>').appendTo($('.mCSB_container')).addClass('new');
      updateScrollbar();
	  }
  });
	setDate();
	updateScrollbar();
}

$('.message-submit').click(function() {
  insertMessage();
  updateScrollbar();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    insertMessage();
    updateScrollbar();
    return false;
  }
})

var welcome = 
  'Hi there, I\'m SALSA. Here\'s the list of tasks I can do for you:<br><br>1. Weather<br>2. Conversion<br>3. Meanings and definitions<br>4. Basic information about people<br>5. Calculations<br>6. Small talk';


function welcomeMessage() {
	speak("Hi there, I'm SALSA. Your virtual assistant. Here's what I can do");
    $('<div class="message new"><figure class="avatar"><img src="images/avatar.jpeg" /></figure>' + welcome + '</div>').appendTo($('.mCSB_container')).addClass('new');
    setDate();
    updateScrollbar();
}