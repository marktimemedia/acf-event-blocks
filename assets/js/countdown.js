function getTimeRemaining(endtime) {
  var total = endtime - Date.parse(new Date());
  var seconds = Math.floor((total / 1000) % 60);
  var minutes = Math.floor((total / 1000 / 60) % 60);
  var hours = Math.floor((total / (1000 * 60 * 60)) % 24);
  var days = Math.floor(total / (1000 * 60 * 60 * 24));

  return {
    total : total,
    days : days,
    hours : hours,
    minutes : minutes,
    seconds : seconds
  };
}

function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  clock.style.display = 'inline-block';

  function updateClock() {
    var t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}

// event is in the future
function displayUpcoming(id, starttime) {
  var block = document.getElementById(id);
  var upcoming = block.querySelector('.upcoming');

  upcoming.style.display = 'inline-block';
}

// event is happening now
function displayEvents(id, starttime, endtime) {
  var block = document.getElementById(id);
  var current = block.querySelector('.current');
  var announce = block.querySelector('.announce-current');

  current.style.display = 'inline-block';
  announce.style.display = 'inline-block';
}

// event is in the past
function afterEvent(id, endtime) {
  var block = document.getElementById(id);
  var past = block.querySelector('.past');
  var announce = block.querySelector('.announce-past');

  past.style.display = 'inline-block';
  announce.style.display = 'inline-block';
}


document.addEventListener('DOMContentLoaded', function(){
  if( document.getElementById('countdownclock') ) {
    var eventStart = Date.parse(new Date());
    var eventEnd = Date.parse(new Date());
    var currentTime = countdownOptions.timezone ? moment().tz(countdownOptions.timezone) : moment();

    if( countdownOptions.start ) {
      eventStart = countdownOptions.timezone ? moment.tz(countdownOptions.start, countdownOptions.timezone ) : Date.parse(countdownOptions.start);
    }

    if( countdownOptions.end ) {
      eventEnd = countdownOptions.timezone ? moment.tz(countdownOptions.end, countdownOptions.timezone ) : Date.parse(countdownOptions.end);
    }

    // console.log('start: ' + eventStart.format() + ', end: ' + eventEnd.format() + ', now: ' + currentTime.format() + ', timezone: ' + countdownOptions.timezone);

    // event is in the future
    if (eventStart > currentTime) {

      initializeClock('countdownclock', eventStart);
      displayUpcoming('infoblock', eventStart);
    // event is happening now
    } else if (currentTime >= eventStart && eventEnd > currentTime) {
      displayEvents('infoblock', eventStart, eventEnd);
    // event is in the past
    } else if (currentTime >= eventEnd) {
      afterEvent('infoblock', eventEnd);
    } else {
      console.log('else');
    }
  }
}, false);
