function getTimeRemaining(e){var n=e-Date.parse(new Date),t=Math.floor(n/1e3%60),o=Math.floor(n/1e3/60%60),i=Math.floor(n/36e5%24),c=Math.floor(n/864e5);return{total:n,days:c,hours:i,minutes:o,seconds:t}}function initializeClock(e,n){function t(){var e=getTimeRemaining(n);i.innerHTML=e.days,c.innerHTML=("0"+e.hours).slice(-2),l.innerHTML=("0"+e.minutes).slice(-2),s.innerHTML=("0"+e.seconds).slice(-2),e.total<=0&&clearInterval(a)}var o=document.getElementById(e),i=o.querySelector(".days"),c=o.querySelector(".hours"),l=o.querySelector(".minutes"),s=o.querySelector(".seconds");o.style.display="inline-block",t();var a=setInterval(t,1e3)}function displayUpcoming(e,n){var t=document.getElementById(e),o=t.querySelector(".upcoming");o.style.display="inline-block"}function displayEvents(e,n,t){var o=document.getElementById(e),i=o.querySelector(".current"),c=o.querySelector(".announce-current");i.style.display="inline-block",c.style.display="inline-block"}function afterEvent(e,n){var t=document.getElementById(e),o=t.querySelector(".past"),i=t.querySelector(".announce-past");o.style.display="inline-block",i.style.display="inline-block"}document.addEventListener("DOMContentLoaded",function(){if(document.getElementById("countdownclock")){var e=Date.parse(new Date),n=Date.parse(new Date),t=moment().tz(countdownOptions.timezone);countdownOptions.start&&(e=countdownOptions.timezone?moment.tz(countdownOptions.start,countdownOptions.timezone):Date.parse(countdownOptions.start)),countdownOptions.end&&(n=countdownOptions.timezone?moment.tz(countdownOptions.end,countdownOptions.timezone):Date.parse(countdownOptions.end)),e>t?(initializeClock("countdownclock",e),displayUpcoming("infoblock",e)):t>=e&&n>t?displayEvents("infoblock",e,n):t>=n&&afterEvent("infoblock",n)}},!1);