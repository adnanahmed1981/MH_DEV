var TextMessage = 'Post a new status...';
function SetMsg (txt, active) {
    if (txt == null) return;
    
    if (active) {
        if (txt.value == TextMessage) txt.value = '';
    } else {
        if (txt.value == '') txt.value = TextMessage;
    }
}

window.onload=function() { SetMsg(document.getElementById('statustxt', false)); }
